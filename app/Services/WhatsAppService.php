<?php

namespace App\Services;

use App\Models\LavadoOrden;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Envía notificación de lavado finalizado vía WhatsApp.
     *
     * Soporta múltiples proveedores. Configura el que prefieras en .env:
     * WHATSAPP_PROVIDER=ultramsg|callmebot|twilio|none
     *
     * @param LavadoOrden $lavado
     * @return array|null
     */
    public function notificarLavadoFinalizado(LavadoOrden $lavado): ?array
    {
        $provider = config('services.whatsapp.provider', 'none');

        if ($provider === 'none') {
            return null;
        }

        $telefono = $this->normalizarTelefono($lavado->cliente->telefono ?? null);

        if (!$telefono) {
            Log::warning("[WhatsApp] Cliente sin teléfono para lavado #{$lavado->id_orden}");
            return null;
        }

        $mensaje = $this->construirMensaje($lavado);

        return match ($provider) {
            'ultramsg' => $this->enviarUltraMsg($telefono, $mensaje),
            'callmebot' => $this->enviarCallMeBot($telefono, $mensaje),
            'twilio' => $this->enviarTwilio($telefono, $mensaje),
            default => null,
        };
    }

    private function construirMensaje(LavadoOrden $lavado): string
    {
        $cliente = $lavado->cliente->nombre ?? 'Cliente';
        $moto = $lavado->moto->placa ?? 'su moto';
        $servicio = $lavado->servicio->nombre ?? 'el servicio';
        $precio = number_format($lavado->precio_total, 2);

        return "¡Hola {$cliente}! 👋\n\n"
            . "Su moto {$moto} ya está lista.\n"
            . "Servicio: {$servicio}\n"
            . "Total a pagar: Bs. {$precio}\n\n"
            . "Gracias por preferirnos. 🏍️✨";
    }

    private function normalizarTelefono(?string $telefono): ?string
    {
        if (!$telefono) return null;

        // Elimina espacios, guiones, paréntesis
        $numero = preg_replace('/[^0-9]/', '', $telefono);

        // Si empieza con 0, lo reemplaza por código de Bolivia (591)
        if (str_starts_with($numero, '0')) {
            $numero = '591' . substr($numero, 1);
        }

        // Si no tiene código de país, asume Bolivia
        if (strlen($numero) <= 8) {
            $numero = '591' . $numero;
        }

        return $numero;
    }

    // ──────────────────────────────────────────
    // ULTRAMSG (https://ultramsg.com)
    // ──────────────────────────────────────────
    private function enviarUltraMsg(string $telefono, string $mensaje): array
    {
        $instanceId = config('services.whatsapp.ultramsg.instance_id');
        $token = config('services.whatsapp.ultramsg.token');

        $response = Http::asForm()->post("https://api.ultramsg.com/{$instanceId}/messages/chat", [
            'token' => $token,
            'to' => '+' . $telefono,
            'body' => $mensaje,
        ]);

        Log::info("[WhatsApp UltraMsg] Enviado a {$telefono}", $response->json());

        return $response->json();
    }

    // ──────────────────────────────────────────
    // CALLMEBOT (gratuito, usa tu propia API key)
    // ──────────────────────────────────────────
    private function enviarCallMeBot(string $telefono, string $mensaje): array
    {
        $apiKey = config('services.whatsapp.callmebot.api_key');

        $response = Http::get('https://api.callmebot.com/whatsapp.php', [
            'phone' => $telefono,
            'text' => $mensaje,
            'apikey' => $apiKey,
        ]);

        Log::info("[WhatsApp CallMeBot] Enviado a {$telefono}", ['status' => $response->status()]);

        return ['status' => $response->status(), 'body' => $response->body()];
    }

    // ──────────────────────────────────────────
    // TWILIO (https://twilio.com)
    // ──────────────────────────────────────────
    private function enviarTwilio(string $telefono, string $mensaje): array
    {
        $sid = config('services.whatsapp.twilio.sid');
        $token = config('services.whatsapp.twilio.token');
        $from = config('services.whatsapp.twilio.from'); // formato: whatsapp:+14155238886

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => 'whatsapp:+' . $telefono,
                'Body' => $mensaje,
            ]);

        Log::info("[WhatsApp Twilio] Enviado a {$telefono}", $response->json());

        return $response->json();
    }
}

