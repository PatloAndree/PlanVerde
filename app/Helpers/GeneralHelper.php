<?php

namespace App\Helpers;

use App\Models\Configuracion;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Auth;

class GeneralHelper
{
    public static function getClientGoogle()
    {
        try {
            $client = new Google_Client();
            $client->setApplicationName(env('APP_NAME'));
            $configuracion = Configuracion::where('id', 1)->first();
            // Configurar la cuenta de servicio
            $client->setAuthConfig(json_decode($configuracion->implementacion_drive_config, true));
            $client->setScopes(Google_Service_Drive::DRIVE);
            $client->setAccessType('offline');
            return $client;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function createFolder($client, $folderName)
    {
        //VERIDCAR CARPETA PRINCIPAL PARA CREAR SUBCARPETAS

        $service = new Google_Service_Drive($client);

        $query = "name = '{$folderName}' and mimeType = 'application/vnd.google-apps.folder' and trashed = false";
        $response = $service->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name)',
        ]);

        if (count($response->files) > 0) {
            // Si la carpeta ya existe, no crearla de nuevo
            return $response->files[0]->id;
        } else {
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder',
            ]);

            $folder = $service->files->create($fileMetadata, ['fields' => 'id']);

            // Asignar permisos a la carpeta
            $permission = new Google_Service_Drive_Permission([
                'type' => 'user',
                'role' => 'writer',
                'emailAddress' => 'torresandreemail@gmail.com' /*planverde2024@gmail.com*/,
            ]);
            $service->permissions->create($folder->id, $permission, ['fields' => 'id']);

            return $folder->id;
        }
    }

    public static function uploadFile($client, $folderId, $filePath, $fileName)
    {
        $basePath = base_path();

        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [$folderId], // Especifica la carpeta donde se subirá el archivo
        ]);
        $filePath = $basePath . '/' . $filePath;
        $content = file_get_contents($filePath);

        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => mime_content_type($filePath),
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);

        return $file->id;
    }

    public function downloadFromGoogleDrive($client, $fileId)
    {
        try {
            $service = new Google_Service_Drive($client);
            $file = $service->files->get($fileId, ['fields' => 'name']);
            $content = $service->files->get($fileId, ['alt' => 'media']);

            $nombreArchivo = $file->name; // Nombre original del archivo

            // Devolver un array con el contenido y el nombre del archivo
            return [
                'content' => $content->getBody()->getContents(),
                'filename' => $nombreArchivo,
            ];
        } catch (Exception $e) {
            return null;
        }
    }

    public function generateDateRange($startDate, $endDate)
    {
        $dates = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('d/m/Y');
            $currentDate->addDay();
        }

        return $dates;
    }

    public function role_route($routeName, $parameters = [])
    {
        $role = Auth::user()->getRoleNames()->first(); // Obtiene el rol del usuario
        return route($role . '.' . $routeName, $parameters);
    }
}
