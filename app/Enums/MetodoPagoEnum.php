<?php

namespace App\Enums;

enum MetodoPagoEnum: string
{
    case EFECTIVO = '1';
    case TARJETA = '2';
    case CHEQUE = '3';
    case VALES = '4';
    case OTROS = '5';
    case PAGO_POSTERIOR = '6';
    case TRANSFERENCIA_BANCARIA = '7';
    case DEPOSITO_EN_CUENTA = '8';
}

