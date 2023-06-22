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
            if (!/[А-Яа-я]+$/.test(this.name)) {
                alert('Введите русские буквы')
                return
            }
            axios.post('/users/create', {
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
