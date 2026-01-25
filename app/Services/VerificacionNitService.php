<?php

namespace App\Services;

use App\Models\ConfiguracionSiat;
use Exception;

class VerificacionNitService
{
    private $configuracion;

    public function __construct()
    {
        $this->configuracion = ConfiguracionSiat::first();
        
        if (!$this->configuracion) {
            throw new Exception('No hay configuración SIAT registrada');
        }
    }

    /**
     * Verificar si un NIT es válido en SIAT
     * 
     * @param string $nitParaVerificacion NIT del cliente a verificar
     * @param int|null $empresaId ID de la empresa (por defecto primera)
     * @return array ['valido' => bool, 'mensaje' => string, 'descripcion' => string]
     */
    public function verificarNit(string $nitParaVerificacion, ?int $empresaId = null): array
    {
        try {
            $config = $empresaId ? ConfiguracionSiat::where('empresa_id', $empresaId)->first() : $this->configuracion;
            
            if (!$config) {
                return [
                    'valido' => false,
                    'mensaje' => 'ERROR',
                    'descripcion' => 'No hay configuración SIAT para esta empresa'
                ];
            }

            // Usar URL de códigos para verificarNit
            $url = $config->url_codigos ?? $config->url_sincronizacion;
            $token = $config->token_api;

            // Configurar SoapClient con header apikey
            $options = [
                'trace' => true,
                'exceptions' => true,
                'connection_timeout' => 10,
                'stream_context' => stream_context_create([
                    'http' => [
                        'header' => 'apikey: ' . $token
                    ]
                ])
            ];

            $client = new \SoapClient($url, $options);

            // Parámetros para solicitar verificación de NIT
            $params = [
                'SolicitudVerificarNit' => [
                    'codigoAmbiente' => (int) $config->codigo_ambiente,
                    'codigoModalidad' => (int) $config->codigo_modalidad,
                    'codigoSistema' => $config->codigo_sistema,
                    'codigoSucursal' => (int) $config->codigo_sucursal,
                    'cuis' => $config->cuis,
                    'nit' => (int) $config->nit,
                    'nitParaVerificacion' => (int) $nitParaVerificacion,
                ]
            ];

            // Llamar a verificarNit
            $response = $client->verificarNit($params);

            // Extraer información de la respuesta
            $respuesta = $response->RespuestaVerificarNit;
            $mensaje = $respuesta->mensajesList;
            $codigo = (string) $mensaje->codigo;
            $descripcion = (string) $mensaje->descripcion;
            
            // NIT activo = código 986
            $valido = $codigo === '986';
            
            return [
                'valido' => $valido,
                'mensaje' => $codigo,
                'descripcion' => $descripcion
            ];

        } catch (Exception $e) {
            return [
                'valido' => false,
                'mensaje' => 'ERROR',
                'descripcion' => $e->getMessage()
            ];
        }
    }
}
