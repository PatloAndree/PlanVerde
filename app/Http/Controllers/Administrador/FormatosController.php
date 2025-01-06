<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formatos;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GeneralHelper;



class FormatosController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'Formatos';
        return view('administrador.formatos', $data);
    }

    public function list()
    {
        $formatos = Formatos::where('status', 1)->get();
        return ['data' => $formatos];
    }

    public function save3(Request $request)
    {
        // Validar los datos recibidos
        $data = $request->json()->all();
        $formato = isset($data['id']) ? Formatos::find($data['id']) : new Formatos();

        if (!$formato) {
            return response()->json(['message' => 'formato no encontrada'], 404);
        }
        $formato->titulo = $data['titulo'];
        $formato->contenido = json_encode($data['preguntas']);
        $formato->fecha_inicio = Carbon::now();
        $formato->save();

        // Retornar respuesta exitosa
        return response()->json(
            [
                'message' => isset($data['id']) ? 'Formato actualizada con éxito' : 'Formato creada con éxito',
                'encuesta' => $formato,
            ],
            isset($data['id']) ? 200 : 201,
        );
    }

    public function save(Request $request)
    {
        // Validar los datos recibidos
        $data = $request->json()->all();
        $formato = isset($data['id']) ? Formatos::find($data['id']) : new Formatos();

        if (!$formato) {
            return response()->json(['message' => 'Formato no encontrado'], 404);
        }

        $formato->titulo = $data['titulo'];
        $formato->contenido = json_encode($data['preguntas']);
        $formato->fecha_inicio = Carbon::now();
        $formato->save();

        // Ruta de la carpeta
        $folderPath = storage_path('app/formatos'); // Puedes cambiar el path según lo necesites

        // Verificar si la carpeta no existe y crearla
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Guardar un archivo como ejemplo
        $fileName = "formato_{$formato->id}.json";
        $filePath = $folderPath . '/' . $fileName;
        File::put($filePath, $formato->contenido);

        // Retornar respuesta exitosa
        return response()->json(
            [
                'message' => isset($data['id']) ? 'Formato actualizado con éxito' : 'Formato creado con éxito',
                'encuesta' => $formato,
                'archivo' => $filePath,
            ],
            isset($data['id']) ? 200 : 201,
        );
    }

    public function sav3e(Request $request) {
        // Validar los datos recibidos
        $data = $request->json()->all();
        $formato = isset($data['id']) ? Formatos::find($data['id']) : new Formatos();
    
        if (!$formato) {
            return response()->json(['message' => 'Formato no encontrado'], 404);
        }
    
        $formato->titulo = $data['titulo'];
        $formato->contenido = json_encode($data['preguntas']);
        $formato->fecha_inicio = Carbon::now();
        $formato->save();
    
        // Guardar en almacenamiento local
        $folderPath = storage_path('app/formatos'); // Carpeta local
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    
        $fileName = "formato_{$formato->id}.json";
        $filePath = $folderPath . '/' . $fileName;
        File::put($filePath, $formato->contenido);
    
        // Subir el archivo a Google Drive
        $client = new Google_Client();
        $client->setApplicationName('Nombre de tu Aplicación');
    
        // Configurar la cuenta de servicio
        $client->setAuthConfig([
            "type"=>"service_account",
            "project_id"=>"gen-lang-client-0182938362",
            "private_key_id"=>"1592c0fc5c540c0c4b332c300dc3af3a04d6b915",
            "private_key"=>"-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCaFH4fMoqOeAou\nvsvBZn1CeZ4eiFpWpKJdEo5wanOqGma2I/0WtAHQE3lavDkwUq6nqKZ7BgCgnbza\ndZ6WhtlGLYq8yXDGW3JfzppD1dXgtf2Ll66BIc64/vttTocflndoGzqmnTH8trFI\nUMG8jdD9W+iKyzXH3+aAk3Cov12Pc5RYbKA/zui0yqqTlqnxMtqQhh7pwv1tbjw/\nwdo1uX4Mbn0aX7ASqOZBUJGfIkjb68gGTCSAjs1iMknRUyaNixWWfLWzWdbUh9Mj\n98DSUd7G3AkUKOZS2TzHMglMI0a3hCuM5QGGLNVy4oxbs1vtgJWe8GyzC7WUMXx5\nRLzYaAdVAgMBAAECggEAEjBWHSexvJTGGvOSCRAovEawGEmfZHgF5LfSkcm3Qr7g\nHiNMdrgkOKR74G60z5QLIyahFIfGXi+Qwjc9U+ayUnsA1D1xbzEPZOj2RAjDuUWy\nmx56TqsnhKYxFxu8jsmL6gHA4DdRVdRZRECoRjJ1l9sYLf5EKIaxZr9A/uKsUEk1\nH3o5H5IMJE3GGHp59UrqvtnlLovjIdK7SNnBYEk08flq1j7p75TOYl3VLDk869q9\nZHQX30MwuiyPMcP1f62nBlmlk5gEO/0P2mlvl5PwJ6fX3O4dBpgTFeSovM7teAkJ\nDJSYQONMHH0N6ku2GqBAU5oq3t+Jdz2JRhD3P2oW8QKBgQDTiDIuSUEh8pOjBymM\nOpli4PwQWKHwQ8nqK2rRmNSLysZHtQb4ltWB/reKzqlmFwF9Io65vUWq3QdLlknx\nUAWK99y3e0DSEj7rWLWFZ1b4acud+35tPoiBQSFOq9oTr9WzFznrOfyiJZQRETEc\nb/XY7N0W1Zf6PsK0qg90ZX2NTQKBgQC6eHZiWfu6I8iHcv6IHxn8x+wAfTTqfnjr\nbo7qPCc7+YrMQ42wCeOj0fPbakKuBVX98v6tFGuIOfpr5XXdz/B/c6KxOj7YlXAr\n/j2drYoWtGvpSsxCW7yRCY53XznJbMElob1CSox0fwTG7Ef2pfuKyMq8sMilUdvk\n2+PjVIL+KQKBgBYSIdo+fnNCUjEycB1Xh+WPP/2codjl2c17FjwkTBkB4UpeEwoh\nAsn7f78V7Qrf36Hk1yt+GiTHxxkV50UsakejsP3b+Fly2enIabgvnh1xPHORaBGR\n8sA5wXXp7GkdcZisFbj7ZeatMRPOzWcAL5CgtjjJtH/ByKL9E3u7kywJAoGAX/IF\nr9tu+7rXvmH795xRKdDQbPv/kzyaCUGsxXdIFML0mN+VcuPTvoIUAGzvfE0AjxdN\n1U6xebmjUYsSl5wbueiM6LX4ikZyHiDGIXCeocoZ0EMNUIOVRedt55wWxr5vr2ZG\nVGq5VGPa2GPRL2b+Q83HC0nHI9E33M0Lt/fPIukCgYBi2zUXeJvSVMU99H1C5vCL\n+CD/hfMDkA9o0iF2d8QPYUkcuBomHaD7dIKMVfFuls2xT3KxXqSdj841UAHB3xgb\ncoI/pGN/X/1mhy2CsFyr3zgs7ChpliKH02CYRnzCfcP/Wb2GjPhgaNNXo4c5OGco\nMP0se0yEO6oGxbGrjdZSLg==\n-----END PRIVATE KEY-----\n",
            "client_email"=>"up-plan-verde@gen-lang-client-0182938362.iam.gserviceaccount.com",
            "client_id"=>"115729483547169412122",
            "auth_uri"=>"https://accounts.google.com/o/oauth2/auth",
            "token_uri"=>"https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url"=>"https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url"=>"https://www.googleapis.com/robot/v1/metadata/x509/up-plan-verde%40gen-lang-client-0182938362.iam.gserviceaccount.com",
            "universe_domain"=>"googleapis.com"
        ]);

        $client->setScopes(Google_Service_Drive::DRIVE);
        $service = new Google_Service_Drive($client);
    
        // Crear carpeta en Google Drive si es necesario
        $folderMetadata = new Google_Service_Drive_DriveFile([
            'name' => 'Formatos',
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);
    
        $folder = $service->files->create($folderMetadata, ['fields' => 'id']);
        $folderId = $folder->id;
    
        // Subir archivo a la carpeta en Google Drive
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [$folderId],
        ]);
    
        $content = file_get_contents($filePath);
        $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/json',
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);
    
        // Retornar respuesta exitosa
        return response()->json([
            'message' => isset($data['id']) ? 'Formato actualizado con éxito' : 'Formato creado con éxito',
            'encuesta' => $formato,
            'archivo_local' => $filePath,
            'archivo_drive' => $fileName,
        ]);
    }

    public function editar($id)
    {
        $fotmato = Formatos::where('id', $id)->where('status', 1)->first();
        return ['data' => $fotmato];
    }

    public function destroy($id)
    {
        $encuesta = Formatos::find($id);
        if (!$encuesta) {
            return response()->json(['success' => false, 'message' => 'Encuesta no encontrada.'], 404);
        }
        try {
            $encuesta->status = 0;
            $encuesta->save();
            return response()->json(['success' => true, 'message' => 'Encuesta eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la encuesta.'], 500);
        }
    }
}
