<?php

namespace Modules\Tema\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\Tema\Repositories\TemaRepository;

class TemaFotoService
{

   /**
    * @var TemaRepository
    */
   private $temaRepository;

   /**
    * Periodoervice constructor.
    * @param TemaRepository $repository
    */
   public function __construct(TemaRepository $temaRepository)
   {
      $this->temaRepository = $temaRepository;
   }

   public static function __deleteArquivoFisico($img)
   {
      if (File::exists("storage/tema/tmb_{$img}")) {
         File::delete("storage/tema/tmb_{$img}");
         File::delete("storage/tema/big_{$img}");
      }
   }

   public function destroyFoto($id, $campo)
   {
      $obj = $this->temaRepository->find($id);
      if (File::exists("storage/tema/tmb_" . $obj->{$campo})) {
         File::delete("storage/tema/tmb_" . $obj->{$campo});
         File::delete("storage/tema/big_" . $obj->{$campo});
      }
      $obj->{$campo} = null;
      $obj->save();
      return response()->json(['error' => 0, 'message' => 'A foto foi removida com sucesso.', 'data' => ['id' => $obj->id]], 200);
   }

   public function saveFoto($id = 0, $request)
   {
      try {
         $obj = $this->temaRepository->find($id);

         // Define qual campo e tamanho usar
         switch ($request->tipo) {
            case 1:
               $campo = 'logo_img';
               $thumbWidth = 400;
               break;
            case 2:
               $campo = 'marca_img';
               $thumbWidth = 400;
               break;
            case 3:
               $campo = 'fundo_img';
               $thumbWidth = 2000;
               break;
         }

         if (!$request->file($campo)) {
            throw new \Exception('Nenhuma imagem enviada!');
         }

         $file = $request->file($campo);

         if ($file->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $file->extension();
            $nameFile = "{$name}.{$extension}";

            // Salva a imagem grande exatamente como veio
            $upload = Image::make($file)
               ->save("storage/tema/big_{$nameFile}");

            // Salva a thumbnail proporcional (sem cortar)
            $thumb = Image::make($file)
               ->resize(300, null, function ($constraint) {
                  $constraint->aspectRatio();
                  $constraint->upsize(); // não aumenta imagem se menor
               })
               ->save("storage/tema/tmb_{$nameFile}");

            if (!$upload || !$thumb) {
               throw new \Exception('Falha ao fazer upload da imagem');
            }

            // Remove arquivos antigos, se existirem
            if ($obj->{$campo}) {
               @unlink("storage/tema/tmb_" . $obj->{$campo});
               @unlink("storage/tema/big_" . $obj->{$campo});
            }

            $obj->{$campo} = $nameFile;
            $obj->save();
         }

         $status = 200;
         $response = [
            'error' => 0,
            'message' => 'O upload da imagem foi concluído com sucesso.',
            'data' => ['id' => $obj->id]
         ];
      } catch (\Exception $e) {
         $status = 400;
         $response = [
            'message' => $e->getMessage()
         ];
      } finally {
         return response()->json($response, $status);
      }
   }


   // public function saveFoto($id = 0, $request)
   // {
   //    try {
   //       $obj = $this->temaRepository->find($id);

   //       if ($request->tipo == 1) {
   //          $campo = 'logo_img';
   //          $w = 400;
   //          $h = null;
   //       } else if ($request->tipo == 2) {
   //          $campo = 'marca_img';
   //          $w = 400;
   //          $h = null;
   //       } else if ($request->tipo == 3) {
   //          $campo = 'fundo_img';
   //          $w = 2000;
   //          $h = 1500;
   //       } else if ($request->tipo == 4) {
   //          $campo = 'game_fundo_img';
   //          $w = 2000;
   //          $h = 1500;
   //       } else if ($request->tipo == 5) {
   //          $campo = 'game_fundo_img_2';
   //          $w = 2000;
   //          $h = 1500;
   //       } else if ($request->tipo == 6) {
   //          $campo = 'game_fundo_img_3';
   //          $w = 2000;
   //          $h = 1500;
   //       } else if ($request->tipo == 7) {
   //          $campo = 'game_fundo_img_sabotador';
   //          $w = 2000;
   //          $h = 1500;
   //       } else if ($request->tipo == 8) {
   //          $campo = 'game_fundo_img_2_sabotador';
   //          $w = 2000;
   //          $h = 1500;
   //       } else if ($request->tipo == 9) {
   //          $campo = 'game_fundo_img_3_sabotador';
   //          $w = 2000;
   //          $h = 1500;
   //       } else {
   //          $campo = 'game_fundo_central_img';
   //          $w = 2000;
   //          $h = 1500;
   //       }

   //       if (!$request->file($campo)) {
   //          throw new \Exception('Nenhuma imagem enviada! ');
   //       }

   //       $file = $request->file($campo);
   //       //            foreach ($request->file('img') as $file) {
   //       if ($file->isValid()) {

   //          $name = uniqid(date('HisYmd'));

   //          // Recupera a extensão do arquivo
   //          $extension = $file->extension();

   //          // Define finalmente o nome
   //          $nameFile = "{$name}.{$extension}";

   //          if ($h) {
   //             $upload = Image::make($file)->fit($w, $h, function ($constraint) {
   //                $constraint->aspectRatio();
   //             })->save("storage/tema/big_{$nameFile}");
   //          } else {
   //             $upload = Image::make($file)->resize($w, null, function ($constraint) {
   //                $constraint->aspectRatio();
   //             })->save("storage/tema/big_{$nameFile}");
   //          }

   //          $upload = Image::make($file)->fit(300, null, function ($constraint) {
   //             $constraint->aspectRatio();
   //          })->save("storage/tema/tmb_{$nameFile}");
   //          // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

   //          // Verifica se NÃO deu certo o upload (Redireciona de volta)
   //          if (!$upload) {
   //             throw new \Exception('Falha ao fazer upload da imagem pequena');
   //          }
   //          $obj = $this->temaRepository->find($id);
   //          if ($obj->{$campo}) {
   //             @unlink("storage/tema/tmb_" . $obj->{$campo});
   //             @unlink("storage/tema/big_" . $obj->{$campo});
   //          }

   //          $obj->{$campo} = $nameFile;
   //          $obj->save();
   //       }
   //       //}

   //       $status = 200;
   //       $response = ['error' => 0, 'message' => '<br>O upload da imagem foi concluído com sucesso.', 'data' => ['id' => $obj->id]];
   //    } catch (\Exception $e) {
   //       $status = 400;
   //       $response = [
   //          'message' => $e->getMessage()
   //       ];
   //    } finally {

   //       return response()->json($response, $status);
   //    }
   // }
}
