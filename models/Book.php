<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    // Definição da tabela associada à model
    // public static function tableName()
    // {
    //     return 'books'; // nome da tabela no banco de dados
    // }

    // Regras de validação
    public function rules()
    {
        return [
            [['id', 'ISBN', 'title', 'publish_year', 'editor', 'editor', 'pages', 'genre', 'synopsis'], 'required'], // Campos obrigatórios
            [['ISBN'], 'unique', 'targetAttribute' => 'ISBN', 'message' => 'Este ISBN já está em uso.', 'filter' => function ($query) {
                // Se não for um novo registro, ignore o ID atual
                if (!$this->isNewRecord) {
                    $query->andWhere(['!=', 'id', $this->id]);
                }
            }],
        ];
    }

    // Atributos que podem ser usados em consultas ou formulários
    public function attributeLabels()
    {
        return [
            'id' => 'ID', // Nome do atributo
            'ISBN' => 'ISBN',
            'title' => 'Título', // Nome do atributo para exibição
            'publish_year' => 'Ano de Publicação', // Nome do atributo para exibição
            'editor' => 'Editora',
            'pages' => 'Páginas',
            'genre' => 'Gênero',
            'synopsis' => 'Sinopse'
        ];
    }

    // Definição de relacionamentos (se houver)
    public function getAuthor()
    {
        return $this->belongsTo(Author::class, ['book_id' => 'id']); // Exemplo de relacionamento
    }
}
