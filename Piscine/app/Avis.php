<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Avis extends Model
{
    public $timestamps = false;
    protected $fillable = ['numAvis','commentaireAvis','noteAvis','dateAvis','numProduit','mailClient'];
    protected $table = 'avis';
    protected $primaryKey = 'numAvis';
    protected $keyType = 'string';

    public static function allReviewsOfThisProduct($id){
        return self::where('numProduit',$id)->get();
    }

    public static function validateReview(){
        request()->validate([
            'mailClient' => ['required','email'],
            'productNumber' => ['required','int'],
            'mark' => ['required','min:0','max:10'],
            'comment' => ['required']
        ]);
    }

    public static function createOrUpdateClientReviewOnThisProduct()
    {
        $avis = self::firstOrNew(['mailClient' => request('mailClient'), 'numProduit' => request('productNumber')]);
        $avis->noteAvis = request('mark');
        $avis->commentaireAvis = request('comment');
        $avis->dateAvis = Date::now()->format('Y-m-d H:i:s');
        $avis->save();
    }
}