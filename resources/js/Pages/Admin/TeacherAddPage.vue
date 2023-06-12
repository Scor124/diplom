<script setup>
import axios from "axios";
</script>
<script>
export default{
    data(){
        return{
            name: '',
            email: '',
            password: '',
            qualification: '',
        }
    },
    methods: {
        addTeacher() {
            axios.post('/teachers/create', {
                name: this.name,
                email: this.email,
                password: this.password,
                qualification: this.qualification,
            })
                .then(function (response) {
                    console.log(response);
                    alert('Преподаватель создан!');
                })
                .catch(function (error) {console.log(error);});
        }
    }
}
</script>
<template>
    <div class="container-fluid text-center">
        <div class="bg-transparent container mt-5">
            <h1>Добавление преподавателя</h1>
            <form @submit.prevent="addTeacher" class="mt-4">
                <!-- Поле имя -->
                <div class="mb-3">
                    <label for="name" class="form-label">Ф.И.О.</label>
                    <input type="text" v-model="name" class="form-control" id="name" required>
                </div>
                <!-- Поле email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email адрес</label>
                    <input type="email" v-model="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="qualification" class="form-label">Специализация</label>
                    <input type="text" v-model="qualification" class="form-control" id="qualification" required>
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
