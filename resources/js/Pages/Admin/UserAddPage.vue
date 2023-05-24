<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

export default{
    components: {},
    data(){
        return{
            name: '',
            email: '',
            password: '',
        }
    },
    methods: {
        addUser: function () {
            axios.post('/api/users/create', {
                name: this.name,
                email: this.email,
                password: this.password
            })
                .then(function (response) {
                    console.log(response);
                    alert('User added successfully!');

                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
</script>

<template>
    <div class="container-fluid text-center">
        <div class="bg-transparent container mt-5">
            <h1>Создание нового пользователя</h1>
            <form @submit.prevent="addUser" class="mt-4">

                <!-- Поле имя -->
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" v-model="name" class="form-control" id="name" required>
                </div>

                <!-- Поле email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email адрес</label>
                    <input type="email" v-model="email" class="form-control" id="email" required>
                </div>

                <!-- Поле пароль -->
                <div class="mb-3 rounded-pill">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" v-model="password" class="form-control" id="password" required>
                </div>

                <!-- Кнопка добавления пользователя -->
                <button type="submit" class="btn btn-primary">Добавить</button>

            </form>

        </div>
    </div>
</template>
<!--
    <h1>Добавление пользователя</h1>
            <form class="container-fluid">
                <fieldset class="row-auto rounded-pill">
                    <label>Ф.И.О.:</label>
                    <input class="form-control" type="text" v-model="name">
                </fieldset>
                <fieldset class="row-auto rounded-pill">
                    <label>Почта:</label>
                    <input class="form-control" type="email" v-model="email">
                </fieldset>
                <fieldset class="row-auto rounded-pill">
                    <label>Пароль:</label>
                    <input class="form-control" type="password" v-model="password">
                </fieldset>
                <fieldset class="flex h-4 justify-content-end mt-4">
                    <button class="btn btn-primary" type="submit" v-on:click.prevent="addUser()">Добавить</button>
                </fieldset>
            </form>
-->
