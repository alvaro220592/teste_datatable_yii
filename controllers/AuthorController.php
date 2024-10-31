<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Author;
use yii\web\Response;
use yii\data\Pagination;

class AuthorController extends Controller
{
    // public function actionGetAuthors(){
    //     \Yii::$app->response->format = Response::FORMAT_JSON;
    //     $authors = Author::find()->all();
    //     return $authors;
    // }

    public function actionGetAuthors($page = 1, $search = '', $per_page = 10)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        // Configurando o Query e a paginação
        $query = Author::find();

        if (!empty($search)) {
            $query->andFilterWhere(['like', 'name', $search])
            ->orFilterWhere(['like', 'pseudonym', $search]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => $per_page != '' ? $per_page : $query->count(),  // Número de registros por página
            'totalCount' => $query->count(),
        ]);

        $pagination->pageSizeLimit = [1, $query->count()];

        // Aplicando paginação à consulta
        $authors = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

        // Retornando os dados e informações de paginação no JSON
        return [
            'authors' => $authors,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'perPage' => $pagination->getPageSize(),
            ],
        ];
    }

    public function actionCriarVarios(){
        for($i = 1; $i < 100; $i++){
            $author = new Author;
            $author->name = 'Nome autor ' . $i;
            $author->pseudonym = 'Pseudônimo autor ' . $i;
            $author->save();
        }
    }
}
