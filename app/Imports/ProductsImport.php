<?php

namespace App\Imports;

use App\Models\products;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $fileName = $row[7];
        // // Récupérer le fichier image du chemin indiqué dans $row[7]
        // $path = Storage::putFileAs('images', $fileName, 'public');

        return new products([
            'reference' => $row[0],
            'designation' => $row[1], 
            'codebare' => $row[2],
            'prix_achat' => $row[3],
            'prix_vente' => $row[4],
            'quantite' => $row[5],
            'section_id' => $row[6],
            'image' => '/storage/images/'.$row[7]
         ]);
         
         
       
    }
}
