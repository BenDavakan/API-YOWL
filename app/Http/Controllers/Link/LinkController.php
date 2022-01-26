<?php

namespace App\Http\Controllers\Link;

use auth;
use App\Models\Link;
use Illuminate\Http\Request;
use Dusterio\LinkPreview\Client;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Link::with('user', 'comments')->orderBy('created_at', 'DESC')->get();
        return  response($links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'link' => ['string', 'required'],
        ]);
        $check = Link::where('link', $fields['link'])->get();


        $previewClient = new  Client($fields['link']);
        // Obtenir un aperçu à partir d'un analyseur spécifique
        $preview = $previewClient->getPreview('general');
        // Convertit la sortie en tableau
        $preview = $preview->toArray();


        $fields = [
            'link' => $fields['link'],
            'title' => $preview['title'],
            'content' => $preview['description']
        ];

        $check = Link::where('link', $fields['link'])->get();

        if (!$check->isEmpty()) {
            $response = [
                'message' => 'already exists',
                'link info' => $check
            ];
            return response($response);
        }
        $newLink = Link::create([
            'link' => $fields['link'],
            'title' => $fields['title'],
            'content' => $fields['content'],
            'user_id' => auth()->user()->id,
        ]);
        $response = [

            'link' => $newLink,
            'message' => 'link add successfully',
        ];
        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $a_link = Link::with('user', 'comments')->find($id);
        return response($a_link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
