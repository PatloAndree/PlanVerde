<?php

namespace App\Http\Controllers\Soporte;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\DocumentoSoporte;
use App\Models\Empresas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

class DocumentoSoporteController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'DocumentoSoporte';
        return view('soporte.documentos', $data);
    }

    public function list()
    {
        $DocumentoSoporte = DocumentoSoporte::with(['empresa', 'usuario'])
            ->where('status', '!=', 0)
            ->get();
        return ['data' => $DocumentoSoporte];
    }

    public function dataEmpresa($id)
    {
        if ($id > 0) {
            $empresas = Empresas::where('id', $id)->get();
        } else {
            $empresas = Empresas::where('status', '!=', 0)->get();
        }

        return $empresas;
    }

    public function listarCarpeta(Request $request)
    {
        $client = new Google_Client();
        $client->setApplicationName('Nombre de tu Aplicación');

        // Configurar la cuenta de servicio
        $client->setAuthConfig([
            'type' => 'service_account',
            'project_id' => 'gen-lang-client-0182938362',
            'private_key_id' => '1592c0fc5c540c0c4b332c300dc3af3a04d6b915',
            'private_key' =>
                "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCaFH4fMoqOeAou\nvsvBZn1CeZ4eiFpWpKJdEo5wanOqGma2I/0WtAHQE3lavDkwUq6nqKZ7BgCgnbza\ndZ6WhtlGLYq8yXDGW3JfzppD1dXgtf2Ll66BIc64/vttTocflndoGzqmnTH8trFI\nUMG8jdD9W+iKyzXH3+aAk3Cov12Pc5RYbKA/zui0yqqTlqnxMtqQhh7pwv1tbjw/\nwdo1uX4Mbn0aX7ASqOZBUJGfIkjb68gGTCSAjs1iMknRUyaNixWWfLWzWdbUh9Mj\n98DSUd7G3AkUKOZS2TzHMglMI0a3hCuM5QGGLNVy4oxbs1vtgJWe8GyzC7WUMXx5\nRLzYaAdVAgMBAAECggEAEjBWHSexvJTGGvOSCRAovEawGEmfZHgF5LfSkcm3Qr7g\nHiNMdrgkOKR74G60z5QLIyahFIfGXi+Qwjc9U+ayUnsA1D1xbzEPZOj2RAjDuUWy\nmx56TqsnhKYxFxu8jsmL6gHA4DdRVdRZRECoRjJ1l9sYLf5EKIaxZr9A/uKsUEk1\nH3o5H5IMJE3GGHp59UrqvtnlLovjIdK7SNnBYEk08flq1j7p75TOYl3VLDk869q9\nZHQX30MwuiyPMcP1f62nBlmlk5gEO/0P2mlvl5PwJ6fX3O4dBpgTFeSovM7teAkJ\nDJSYQONMHH0N6ku2GqBAU5oq3t+Jdz2JRhD3P2oW8QKBgQDTiDIuSUEh8pOjBymM\nOpli4PwQWKHwQ8nqK2rRmNSLysZHtQb4ltWB/reKzqlmFwF9Io65vUWq3QdLlknx\nUAWK99y3e0DSEj7rWLWFZ1b4acud+35tPoiBQSFOq9oTr9WzFznrOfyiJZQRETEc\nb/XY7N0W1Zf6PsK0qg90ZX2NTQKBgQC6eHZiWfu6I8iHcv6IHxn8x+wAfTTqfnjr\nbo7qPCc7+YrMQ42wCeOj0fPbakKuBVX98v6tFGuIOfpr5XXdz/B/c6KxOj7YlXAr\n/j2drYoWtGvpSsxCW7yRCY53XznJbMElob1CSox0fwTG7Ef2pfuKyMq8sMilUdvk\n2+PjVIL+KQKBgBYSIdo+fnNCUjEycB1Xh+WPP/2codjl2c17FjwkTBkB4UpeEwoh\nAsn7f78V7Qrf36Hk1yt+GiTHxxkV50UsakejsP3b+Fly2enIabgvnh1xPHORaBGR\n8sA5wXXp7GkdcZisFbj7ZeatMRPOzWcAL5CgtjjJtH/ByKL9E3u7kywJAoGAX/IF\nr9tu+7rXvmH795xRKdDQbPv/kzyaCUGsxXdIFML0mN+VcuPTvoIUAGzvfE0AjxdN\n1U6xebmjUYsSl5wbueiM6LX4ikZyHiDGIXCeocoZ0EMNUIOVRedt55wWxr5vr2ZG\nVGq5VGPa2GPRL2b+Q83HC0nHI9E33M0Lt/fPIukCgYBi2zUXeJvSVMU99H1C5vCL\n+CD/hfMDkA9o0iF2d8QPYUkcuBomHaD7dIKMVfFuls2xT3KxXqSdj841UAHB3xgb\ncoI/pGN/X/1mhy2CsFyr3zgs7ChpliKH02CYRnzCfcP/Wb2GjPhgaNNXo4c5OGco\nMP0se0yEO6oGxbGrjdZSLg==\n-----END PRIVATE KEY-----\n",
            'client_email' => 'up-plan-verde@gen-lang-client-0182938362.iam.gserviceaccount.com',
            'client_id' => '115729483547169412122',
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/up-plan-verde%40gen-lang-client-0182938362.iam.gserviceaccount.com',
            'universe_domain' => 'googleapis.com',
        ]);

        $client->addScope(Google_Service_Drive::DRIVE_READONLY); // Establecer el alcance

        // Autenticarse
        $service = new Google_Service_Drive($client);
        // Listar archivos
        try {
            $response = $service->files->listFiles([
                'q' => "mimeType='application/vnd.google-apps.folder'", // Filtrar solo carpetas
                'pageSize' => 10, // Número de carpetas a listar
                'fields' => 'nextPageToken, files(id, name)', // Campos a retornar
            ]);

            $folders = $response->getFiles();
            if (count($folders) == 0) {
                return response()->json(['message' => 'No se encontraron carpetas.']);
            } else {
                return response()->json(['folders' => $folders]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function crearCarpeta(Request $request)
    {
        //Crear carpeta

        $client = new Google_Client();
        $client->setApplicationName('Nombre de tu Aplicación');

        // Configurar la cuenta de servicio
        $client->setAuthConfig([
            'type' => 'service_account',
            'project_id' => 'gen-lang-client-0182938362',
            'private_key_id' => '1592c0fc5c540c0c4b332c300dc3af3a04d6b915',
            'private_key' =>
                "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCaFH4fMoqOeAou\nvsvBZn1CeZ4eiFpWpKJdEo5wanOqGma2I/0WtAHQE3lavDkwUq6nqKZ7BgCgnbza\ndZ6WhtlGLYq8yXDGW3JfzppD1dXgtf2Ll66BIc64/vttTocflndoGzqmnTH8trFI\nUMG8jdD9W+iKyzXH3+aAk3Cov12Pc5RYbKA/zui0yqqTlqnxMtqQhh7pwv1tbjw/\nwdo1uX4Mbn0aX7ASqOZBUJGfIkjb68gGTCSAjs1iMknRUyaNixWWfLWzWdbUh9Mj\n98DSUd7G3AkUKOZS2TzHMglMI0a3hCuM5QGGLNVy4oxbs1vtgJWe8GyzC7WUMXx5\nRLzYaAdVAgMBAAECggEAEjBWHSexvJTGGvOSCRAovEawGEmfZHgF5LfSkcm3Qr7g\nHiNMdrgkOKR74G60z5QLIyahFIfGXi+Qwjc9U+ayUnsA1D1xbzEPZOj2RAjDuUWy\nmx56TqsnhKYxFxu8jsmL6gHA4DdRVdRZRECoRjJ1l9sYLf5EKIaxZr9A/uKsUEk1\nH3o5H5IMJE3GGHp59UrqvtnlLovjIdK7SNnBYEk08flq1j7p75TOYl3VLDk869q9\nZHQX30MwuiyPMcP1f62nBlmlk5gEO/0P2mlvl5PwJ6fX3O4dBpgTFeSovM7teAkJ\nDJSYQONMHH0N6ku2GqBAU5oq3t+Jdz2JRhD3P2oW8QKBgQDTiDIuSUEh8pOjBymM\nOpli4PwQWKHwQ8nqK2rRmNSLysZHtQb4ltWB/reKzqlmFwF9Io65vUWq3QdLlknx\nUAWK99y3e0DSEj7rWLWFZ1b4acud+35tPoiBQSFOq9oTr9WzFznrOfyiJZQRETEc\nb/XY7N0W1Zf6PsK0qg90ZX2NTQKBgQC6eHZiWfu6I8iHcv6IHxn8x+wAfTTqfnjr\nbo7qPCc7+YrMQ42wCeOj0fPbakKuBVX98v6tFGuIOfpr5XXdz/B/c6KxOj7YlXAr\n/j2drYoWtGvpSsxCW7yRCY53XznJbMElob1CSox0fwTG7Ef2pfuKyMq8sMilUdvk\n2+PjVIL+KQKBgBYSIdo+fnNCUjEycB1Xh+WPP/2codjl2c17FjwkTBkB4UpeEwoh\nAsn7f78V7Qrf36Hk1yt+GiTHxxkV50UsakejsP3b+Fly2enIabgvnh1xPHORaBGR\n8sA5wXXp7GkdcZisFbj7ZeatMRPOzWcAL5CgtjjJtH/ByKL9E3u7kywJAoGAX/IF\nr9tu+7rXvmH795xRKdDQbPv/kzyaCUGsxXdIFML0mN+VcuPTvoIUAGzvfE0AjxdN\n1U6xebmjUYsSl5wbueiM6LX4ikZyHiDGIXCeocoZ0EMNUIOVRedt55wWxr5vr2ZG\nVGq5VGPa2GPRL2b+Q83HC0nHI9E33M0Lt/fPIukCgYBi2zUXeJvSVMU99H1C5vCL\n+CD/hfMDkA9o0iF2d8QPYUkcuBomHaD7dIKMVfFuls2xT3KxXqSdj841UAHB3xgb\ncoI/pGN/X/1mhy2CsFyr3zgs7ChpliKH02CYRnzCfcP/Wb2GjPhgaNNXo4c5OGco\nMP0se0yEO6oGxbGrjdZSLg==\n-----END PRIVATE KEY-----\n",
            'client_email' => 'up-plan-verde@gen-lang-client-0182938362.iam.gserviceaccount.com',
            'client_id' => '115729483547169412122',
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/up-plan-verde%40gen-lang-client-0182938362.iam.gserviceaccount.com',
            'universe_domain' => 'googleapis.com',
        ]);
        $client->setScopes(Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');

        // Autenticarse
        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => 'PlanVerde',
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);

        try {
            $folder = $service->files->create($fileMetadata, [
                'fields' => 'id', // Solicita que se devuelva el ID de la carpeta creada
            ]);
            $permission = new Google_Service_Drive_Permission([
                'type' => 'user',
                'role' => 'writer', // O 'owner' si quieres transferir la propiedad
                'emailAddress' => 'torresandreemail@gmail.com' /*planverde2024@gmail.com*/,
            ]);
            $service->permissions->create($folder->id, $permission, ['fields' => 'id']);

            echo 'Carpeta creada con ID: ' . $folder->id . "\n";
        } catch (Exception $e) {
            echo 'Error al crear la carpeta: ' . $e->getMessage();
        }
    }

    public function compartirCarpeta()
    {
        $client = new Google_Client();
        $client->setApplicationName('Nombre de tu Aplicación');

        // Configurar la cuenta de servicio
        $client->setAuthConfig([
            'type' => 'service_account',
            'project_id' => 'gen-lang-client-0182938362',
            'private_key_id' => '1592c0fc5c540c0c4b332c300dc3af3a04d6b915',
            'private_key' =>
                "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCaFH4fMoqOeAou\nvsvBZn1CeZ4eiFpWpKJdEo5wanOqGma2I/0WtAHQE3lavDkwUq6nqKZ7BgCgnbza\ndZ6WhtlGLYq8yXDGW3JfzppD1dXgtf2Ll66BIc64/vttTocflndoGzqmnTH8trFI\nUMG8jdD9W+iKyzXH3+aAk3Cov12Pc5RYbKA/zui0yqqTlqnxMtqQhh7pwv1tbjw/\nwdo1uX4Mbn0aX7ASqOZBUJGfIkjb68gGTCSAjs1iMknRUyaNixWWfLWzWdbUh9Mj\n98DSUd7G3AkUKOZS2TzHMglMI0a3hCuM5QGGLNVy4oxbs1vtgJWe8GyzC7WUMXx5\nRLzYaAdVAgMBAAECggEAEjBWHSexvJTGGvOSCRAovEawGEmfZHgF5LfSkcm3Qr7g\nHiNMdrgkOKR74G60z5QLIyahFIfGXi+Qwjc9U+ayUnsA1D1xbzEPZOj2RAjDuUWy\nmx56TqsnhKYxFxu8jsmL6gHA4DdRVdRZRECoRjJ1l9sYLf5EKIaxZr9A/uKsUEk1\nH3o5H5IMJE3GGHp59UrqvtnlLovjIdK7SNnBYEk08flq1j7p75TOYl3VLDk869q9\nZHQX30MwuiyPMcP1f62nBlmlk5gEO/0P2mlvl5PwJ6fX3O4dBpgTFeSovM7teAkJ\nDJSYQONMHH0N6ku2GqBAU5oq3t+Jdz2JRhD3P2oW8QKBgQDTiDIuSUEh8pOjBymM\nOpli4PwQWKHwQ8nqK2rRmNSLysZHtQb4ltWB/reKzqlmFwF9Io65vUWq3QdLlknx\nUAWK99y3e0DSEj7rWLWFZ1b4acud+35tPoiBQSFOq9oTr9WzFznrOfyiJZQRETEc\nb/XY7N0W1Zf6PsK0qg90ZX2NTQKBgQC6eHZiWfu6I8iHcv6IHxn8x+wAfTTqfnjr\nbo7qPCc7+YrMQ42wCeOj0fPbakKuBVX98v6tFGuIOfpr5XXdz/B/c6KxOj7YlXAr\n/j2drYoWtGvpSsxCW7yRCY53XznJbMElob1CSox0fwTG7Ef2pfuKyMq8sMilUdvk\n2+PjVIL+KQKBgBYSIdo+fnNCUjEycB1Xh+WPP/2codjl2c17FjwkTBkB4UpeEwoh\nAsn7f78V7Qrf36Hk1yt+GiTHxxkV50UsakejsP3b+Fly2enIabgvnh1xPHORaBGR\n8sA5wXXp7GkdcZisFbj7ZeatMRPOzWcAL5CgtjjJtH/ByKL9E3u7kywJAoGAX/IF\nr9tu+7rXvmH795xRKdDQbPv/kzyaCUGsxXdIFML0mN+VcuPTvoIUAGzvfE0AjxdN\n1U6xebmjUYsSl5wbueiM6LX4ikZyHiDGIXCeocoZ0EMNUIOVRedt55wWxr5vr2ZG\nVGq5VGPa2GPRL2b+Q83HC0nHI9E33M0Lt/fPIukCgYBi2zUXeJvSVMU99H1C5vCL\n+CD/hfMDkA9o0iF2d8QPYUkcuBomHaD7dIKMVfFuls2xT3KxXqSdj841UAHB3xgb\ncoI/pGN/X/1mhy2CsFyr3zgs7ChpliKH02CYRnzCfcP/Wb2GjPhgaNNXo4c5OGco\nMP0se0yEO6oGxbGrjdZSLg==\n-----END PRIVATE KEY-----\n",
            'client_email' => 'up-plan-verde@gen-lang-client-0182938362.iam.gserviceaccount.com',
            'client_id' => '115729483547169412122',
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/up-plan-verde%40gen-lang-client-0182938362.iam.gserviceaccount.com',
            'universe_domain' => 'googleapis.com',
        ]);
        $client->setScopes(['https://www.googleapis.com/auth/drive']);
        $client->setAccessType('offline');

        $permission = new Google_Service_Drive_Permission([
            'type' => 'user',
            'role' => 'writer', // O 'owner' si quieres transferir la propiedad
            'emailAddress' => 'torresandreemail@gmail.com' /*planverde2024@gmail.com */,
        ]);
        $service = new Google_Service_Drive($client);

        // Crear el permiso
        $result = $service->permissions->create('1ZWcpktVaucP3Y0eyiXkQWwBeuLsZsVsO', $permission, ['fields' => 'id']);

        echo '<pre>';
        print_r($result);
        echo '</pre>';
        exit();
    }

    public function save(Request $request)
    {
        $request->validate([
            'documento_id' => 'nullable|integer',
            'nombre' => 'required|string',
            'tipo' => 'required|integer',
            'status' => 'required|integer',
            'archivo' => 'nullable|file',
        ]);

        // Configuración google
        $client = GeneralHelper::getClientGoogle();
        // Crear u Obtener ID FOLDER
        $folderID = GeneralHelper::createFolder($client, 'PlanVerde');

        $archivo = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();
        $fileName = date('Ymd') . '-' . time() . '.' . $extension;

        $archivo->storeAs('uploads', $fileName);
        $filePath = "storage/app/private/uploads/{$fileName}";

        // Subir el archivo a la    peta
        $fileId = GeneralHelper::uploadFile($client, $folderID, $filePath, $fileName);

        $data = [
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'ruta' => $filePath,
            'extension' => $extension,
            'tipo' => $request->tipo,
            'file_id' => $fileId,
            'status' => $request->status,
        ];

        $documento = DocumentoSoporte::updateOrCreate(['id' => $request->documento_id], $data);

        if ($documento) {
            return response()->json(['success' => true, 'id' => $documento->id, 'file_id' => $documento->file_id, 'message' => 'Archivo subido exitosamente']);
        } else {
            return response()->json(['success' => false, 'id', 'message' => 'Ocurrio un problema intentalo nuecamente']);
        }
    }

    public function download($id)
    {
        $basePath = base_path();
        $documento = DocumentoSoporte::where('id', $id)->where('status', 1)->first();
        if (!$documento) {
            return response()->json(['error' => 'Documento no encontrado o inactivo'], 404);
        }

        //$filePath = Storage::path("private/uploads/{$fileName}");
        $rutaArchivo = $basePath . '/' . $documento->ruta;
        $nombreArchivo = $documento->nombre; // Nombre completo del archivo, e.g., 'archivo.pdf'

        if (file_exists($rutaArchivo)) {
            // Si el archivo existe en el almacenamiento local
            return response()->download($rutaArchivo, $nombreArchivo);
        } else {
            // Descargar desde Google Drive si el archivo no está en local
            $client = GeneralHelper::getClientGoogle();
            $descarga = GeneralHelper::downloadFromGoogleDrive($client, $documento->file_id);

            if ($descarga) {
                // Usar el nombre obtenido desde Google Drive
                return response($descarga['content'])
                    ->header('Content-Type', 'application/octet-stream')
                    ->header('Content-Disposition', 'attachment; filename="' . $descarga['filename'] . '"');
            } else {
                return response()->json(['error' => 'Error al descargar desde Google Drive'], 500);
            }
        }
    }
}
