<?php

namespace App\Http\Controllers;

use App\Models\Bkup;

class DatabaseController extends Controller
{


    public function getAll()
    {
        return Bkup::all();
    }

    // Backup do banco de dados do site
    public function geraBkupBancoNovo()
    {

        // para uso na criacao do arquivo
        $timeGet = date("Y_m_d_H_i_s");


        // dados para conexão com o banco
        $dbhost = 'localhost';          //local aonde se encontra o banco de dados
        $dbuser = '';    // usuário do banco de dados
        $dbpass = '';         // senha do usuário do banco de dados
        $dbname = 'totem';   // nome do banco de dados

        // rotina que faz o backup não mexer

        $backupfile = 'Autobackup_' . $timeGet . '.sql';
        $backupzip = $backupfile . '.tar.gz';
        $publicPath = '../public';
        $tempDir = 'bkup_public'; // Nome do diretório temporário

        // Cria o diretório temporário e copia a pasta public para dentro dele
        system("
                mkdir -p $tempDir;
                [ -d $publicPath/eventos ] && cp -R $publicPath/eventos $tempDir/;
                [ -d $publicPath/eventosimgadicional ] && cp -R $publicPath/eventosimgadicional $tempDir/;
                [ -d $publicPath/imagens ] && cp -R $publicPath/imagens $tempDir/;
                [ -d $publicPath/bg ] && cp -R $publicPath/bg $tempDir/;
                ");

        system("mysqldump -h $dbhost -u $dbuser -p$dbpass --lock-tables $dbname > $backupfile");

        // Cria o arquivo tar.gz com o backup do banco e a pasta public (dentro do diretório temporário)
        system("tar -czvf $backupzip $backupfile $tempDir");
        system("rm -rf $tempDir");

        $this->makeDir('documentos/bkupbanco');

        rename('Autobackup_' . $timeGet . '.sql.tar.gz', 'documentos/bkupbanco/Autobackup_' . $timeGet . '.sql.tar.gz');

        //save file

        $destination_path = 'documentos/bkupbanco/';
        $filenameBase = 'Autobackup_' . $timeGet . '.sql.tar.gz';
        // save file data into database //

        $bkup = new Bkup();
        $bkup->filename = $filenameBase;
        $bkup->rotulo = $filenameBase;
        $bkup->tipo = 'tar.gz';
        $bkup->mime = 'tar.gz';
        $bkup->path = $destination_path . $filenameBase;
        $bkup->save();

        unlink($backupfile);

    }


    function makeDir($path)
    {
        return mkdir($path) || is_dir($path);
    }
}
