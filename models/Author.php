<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    // Definição da tabela associada à model
    public static function tableName()
    {
        return 'authors'; // nome da tabela no banco de dados
    }

    // Regras de validação
    public function rules()
    {
        return [
            [['name', 'pseudonym'], 'required'], // Campos obrigatórios
            [['name'], 'string', 'max' => 255], // Validação do tamanho máximo
        ];
    }

    // Atributos que podem ser usados em consultas ou formulários
    public function attributeLabels()
    {
        return [
            'id' => 'ID', // Nome do atributo
            'name' => 'Nome', // Nome do atributo para exibição
            'pseudonym' => 'Pseudônimo', // Nome do atributo para exibição
        ];
    }

    // // Definição de relacionamentos (se houver)
    // public function getBooks()
    // {
    //     return $this->hasMany(Books::class, ['author_id' => 'id']); // Exemplo de relacionamento
    // }
}
