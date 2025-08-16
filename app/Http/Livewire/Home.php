<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Home extends Component
{
    public $relations = [
        "Ayah" => 'ayah',
        "Ibu" => 'ibu',
        "Anak" => 'anak',
        "Saudara" => 'saudara',
    ];

    public $baseUrlApi;

    public $nationalities = [];

    public $nId;

    public $nName;

    public $nCode;

    public $users = [];

    public $uId;

    public $uName;

    public $uDob;

    public $uEmail;

    public $uPhone;

    public $uNationality;

    public $families = [
        [
            "fId" => NULL,
            "fName" => NULL,
            "fDob" => NULL,
            "fRelation" => NULL,
        ]
    ];

    public function mount(){
        $this->baseUrlApi = config('app.go_api_url');
        $this->getNationality();
        $this->getUser();
    }


    public function addFamily(){
        $this->families[] = [
            "fId" => NULL,
            "fName" => NULL,
            "fDob" => NULL,
            "fRelation" => NULL,
        ];
    }

    public function deleteFamily($index){
        unset($this->families[$index]);
    }

    public function resetNa(){
        $this->reset('nName','nCode','nId');
    }

    public function getNationality(){
        $url = $this->baseUrlApi.'/nationality';
        $nationalities = Http::get($url);

        $nationalities = $nationalities->json();
        $this->nationalities = $nationalities['data'];
    }

    public function naEdit($nId){
        $na = collect($this->nationalities)->keyBy('id')?->get($nId);
        $this->nId = $nId;
        $this->nName = $na['name'];
        $this->nCode = $na['code'];
    }

    public function naSave(){
        $this->validate([
            'nCode' => ['required'],
            'nName' => ['required'],
        ]);
        $url = $this->baseUrlApi.'/nationality/create';
        if($this->nId){
            $url = $this->baseUrlApi.'/nationality/update/'.$this->nId;

        }
        $res = Http::post($url,[
            "code" => $this->nCode,
            "name" => $this->nName,
        ]);
        $this->resetNa();
        $this->getNationality();

    }

    public function naDelete($nId){
        $url = $this->baseUrlApi.'/nationality/delete/'.$nId;
        $res = Http::delete($url);
        $this->getNationality();
    }

    public function uReset(){
        $this->reset('uId','uName','uDob','uEmail','uPhone','uNationality','families');
    }

    public function getUser(){
        $url = $this->baseUrlApi.'/user';
        $users = Http::get($url);
        $users = $users->json();

        $nation = collect($this->nationalities)->keyBy('id');
        $this->users = array_map(function($v)use($nation){
            $v['nationality'] = $nation->get($v['nationality_id'])['name'] ?? NULL;
            return $v;
        },$users['data']);
    }

    public function userSave(){
        $this->validate([
            'uName' => ['required'],
            'uDob' => ['required'],
            'uEmail' => ['required'],
            'uPhone' => ['required'],
            'uNationality' => ['required'],
            'families' => ['array','min:1'],
            'families.*.fName' => ['required'],
            'families.*.fDob' => ['required'],
            'families.*.fRelation' => ['required'],
        ]);

        $uUrl = $this->baseUrlApi.'/user/create';
        if($this->nId){
            $uUrl = $this->baseUrlApi.'/user/'.$this->uId.'update';

        }

        $uRes = Http::post($uUrl,[
            "name" => $this->uName,
            "dob" => Carbon::parse($this->uDob)->format('Y-m-d'),
            "email" => $this->uEmail,
            "nationality_id" => (int)$this->uNationality,
            "phone" => $this->uPhone,
        ]);

        $rUId = $uRes->json()['data']['cst_id'];
        $fUrl = $this->baseUrlApi.'/user/'.$rUId.'/family/update';

        $fReq = array_map(function($v){
            $return = [
                'id' => $v['fId'],
                'name' => $v['fName'],
                'dob' => $v['fDob'],
                'relation' => $v['fRelation'],
            ];
            if($return['id'] == NULL){
                unset($return['id']);
            }
            return $return;
        },$this->families);
        $fRes = Http::post($fUrl,['families' => $fReq]);
        $this->uReset();
        $this->getUser();
    }

    public function userEdit($userId){
        $usr = collect($this->users)->keyBy('cst_id')?->get($userId);
        $this->uId = $userId;
        $this->uName = $usr['name'];
        $this->uDob = $usr['dob'];
        $this->uEmail = $usr['email'];
        $this->uPhone = $usr['phone'];
        $this->uNationality = $usr['nationality_id'];

        if(count($usr['families']) > 0){
            $this->families = array_map(function($v){
                return [
                    "fId" => $v['id'],
                    "fName" => $v['name'],
                    "fDob" => $v['dob'],
                    "fRelation" => $v['relation'],
                ];
            },$usr['families']);
        }
    }

    public function userDelete($userId){
        $url = $this->baseUrlApi.'/user/'.$userId.'/delete';
        $res = Http::delete($url);
        $this->getUser();
    }

    public function render()
    {
        return view('livewire.home')
            ->extends('layouts.app');
    }
}
