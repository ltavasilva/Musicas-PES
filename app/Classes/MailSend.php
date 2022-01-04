<?php

namespace App\Classes;

use App\Models\VwEscala;
use Illuminate\Support\Facades\Mail;

class MailSend
{
    public static function NovaEscala($id)
    {
        $escala = VwEscala::Where('id', '=', $id)->get();

        foreach ($escala as &$ministerio) {

            $param['nome'] = "Paróquia Espirito Santo";
            $param['escala'] = $ministerio->toArray();
            $param['msgInicial'] = "Está disponível uma nova";

            Mail::send('Emails.escala', $param, function($mail) use ($ministerio){
            $mail->from('pes.musicas@gmail.com', 'Músicas PES')
                ->to($ministerio->emailResp, $ministerio->responsavel)
                ->subject('Nova escala');

                if(isset($ministerio->emailCorresp)){
                    $mail->cc($ministerio->emailCorresp, $ministerio->corresponsavel);
                }
            });
        }
    }

    public static function AlteraEscala($id)
    {
        $escala = VwEscala::Where('id', '=', $id)->get();

        foreach ($escala as &$ministerio) {

            $param['nome'] = "Paróquia Espirito Santo";
            $param['escala'] = $ministerio->toArray();
            $param['msgInicial'] = "Houve uma alteração na";

            Mail::send('Emails.escala', $param, function($mail) use ($ministerio){
            $mail->from('pes.musicas@gmail.com', 'Músicas PES')
                ->to($ministerio->emailResp, $ministerio->responsavel)
                ->subject('Escala Alterada');

                if(isset($ministerio->emailCorresp)){
                    $mail->cc($ministerio->emailCorresp, $ministerio->corresponsavel);
                }
            });
        }
    }
}