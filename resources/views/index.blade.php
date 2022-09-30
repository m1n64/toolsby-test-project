<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tools.by TEST</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200">

<div x-data="indexPage">
    <div class="flex justify-between bg-gray-500 text-white fixed w-full z-50 top-0">
        <div class="flex flex-row">
            <div class="p-4 font-bold">
                <span class="bg-red-600 px-1">t</span>ools.by <span class="text-gray-200">TEST</span>
            </div>

            <div class="p-4">
                <a class="nav-link" @click="scrollTo('#pallets')">Паллеты</a>
            </div>

            <div class="p-4">
                <a class="nav-link" @click="scrollTo('#finalSum')">Сумма</a>
            </div>
        </div>

        <div class="p-4">
            <a class="border-4 border-solid border-green-500 px-3 py-2 bg-white rounded-full text-green-500 hover:bg-green-500 hover:text-white"
               href="{{ url("/api/documentation") }}" target="_blank">Swagger API DOCS</a>
        </div>
    </div>
    <div class="container mx-auto my-5">
        <div id="pallets" class="mt-[8%]">
            <h1 class="block-caption">Рейсы с информацией о паллетах:</h1>
            <template x-if="palletsInfo.length === 0">
                <div class="loading-text">Загрузка...</div>
            </template>
            <template x-if="palletsInfo.length > 0">
                <table class="main-table">
                    <thead class="">
                    <tr class="">
                        <th>ID машины</th>
                        <th>Фамилия</th>
                        <th>Тип</th>
                        <th>Количество</th>
                        <th>Время старта машины</th>
                        <th>Фактическая дата смены</th>
                    </tr>
                    </thead>
                    <tbody class="">
                    <template x-for="pallet in palletsInfo">
                        <tr class="">
                            <td x-text="pallet.id"></td>
                            <td x-text="pallet.name"></td>
                            <td x-text="pallet.type"></td>
                            <td x-text="pallet.pallets"></td>
                            <td x-text="pallet.start_time"></td>
                            <td x-text="pallet.actual_date"></td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </template>
        </div>

        <div id="finalSum">
            <h1 class="block-caption">Итоговая сумма по сотрудникам:</h1>
            <template x-if="finalSumInfo.length === 0">
                <div class="loading-text">Загрузка...</div>
            </template>
            <template x-if="finalSumInfo.length > 0">
                <table class="main-table">
                    <thead>
                    <tr>
                        <th>Фамилия</th>
                        <th>Количество машин</th>
                        <th>Количество паллет</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template x-for="employee in finalSumInfo">
                        <tr>
                            <td x-text="employee.name"></td>
                            <td x-text="employee.cars"></td>
                            <td x-text="employee.pallets"></td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </template>
        </div>
    </div>
    <div class="bg-gray-800 p-4 text-white flex justify-between">
        <div>30.09.2022</div>
        <div>
            <a class="bg-white border-4 border-solid border-transparent rounded-full text-gray-800 font-bold px-3 py-2 hover:text-white hover:bg-gray-800 hover:border-white" href="https://github.com/m1n64/toolsby-test-project" target="_blank">Github</a>
        </div>
    </div>
</div>

<script src="{{ asset("js/app.js") }}"></script>
<script src="{{ asset("js/index.js") }}"></script>
</body>
</html>
