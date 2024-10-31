<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Autores aqui
    </p>

    <div style="background-color: #eaeaea; padding: 10px">
        
        <input type="text" id="busca" class="form-control mb-3" placeholder="buscar">

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Pseudônimo</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        
        <div class="d-flex justify-content-between">
            <div id="per_page_container">
                <select id="per_page_select">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="">Todos</option>
                </select> Por página
            </div>
            <div class="pagination d-flex flex-wrap"></div>
        </div>
    </div>

    <!-- <code><?= __FILE__ ?></code> -->
</div>

<script>
    let api_url = 'http://localhost:8000/index.php?r=author/get-authors';
    
    async function get_authors(page = 1, search = '', per_page = 10) {
        const req = await fetch(`${api_url}&page=${page}&search=${encodeURIComponent(search)}&per_page=${encodeURIComponent(per_page)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const res = await req.json();
        
        fill_authors_table(res.authors);
        fill_authors_pagination(res.pagination);
    }

    function fill_authors_table(data) {        
        let tbody = document.querySelector('tbody');
        tbody.innerHTML = '';

        data.forEach(item => {
            tbody.innerHTML += `<tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.pseudonym}</td>
            </tr>`;
        });
    }

    function fill_authors_pagination(pagination) {
        let pagination_div = document.querySelector('.pagination');
        
        pagination_div.innerHTML = '';

        // Botão "Anterior"
        if (pagination.currentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.textContent = 'Anterior';
            prevButton.onclick = () => get_authors(pagination.currentPage - 1, document.getElementById('busca').value, document.getElementById('per_page_select').value);
            pagination_div.appendChild(prevButton);
        }

        // Botões de página numerada
        for (let i = 1; i <= pagination.pageCount; i++) { // Usando <= para incluir a última página
            const pageButton = document.createElement('button');

            pageButton.textContent = i;
            if (i === pagination.currentPage) {
                pageButton.classList.add('bg-warning');
            }

            if (i <= pagination.currentPage - 4) {
                pageButton.classList.add('d-none');
            }

            if (i >= pagination.currentPage + 4) {
                pageButton.classList.add('d-none');
            }

            pageButton.onclick = () => get_authors(i, document.getElementById('busca').value, document.getElementById('per_page_select').value);
            pagination_div.appendChild(pageButton);
        }

        // Botão "Próximo"
        if (pagination.currentPage < pagination.pageCount) {
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Próximo';
            nextButton.onclick = () => get_authors(pagination.currentPage + 1, document.getElementById('busca').value, document.getElementById('per_page_select').value);
            pagination_div.appendChild(nextButton);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('busca').addEventListener('keyup', function(){
            get_authors(1, this.value, document.getElementById('per_page_select').value)
        })

        document.getElementById('per_page_select').addEventListener('change', function(){
            get_authors(1, document.getElementById('busca').value, this.value)
        })

        get_authors();
    });
</script>

