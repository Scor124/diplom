<script setup>
import axios from "axios";
const props = defineProps({
    groupId: {
        type: Number
    }
});
console.log(props);
</script>
<script>
export default{
    data(){
        return{
            name: '',
            email: '',
            password: '',
        }
    },
    methods: {
        addStudent() {
            if (!/[А-Яа-я]+$/.test(this.name)) {
                alert('Введите русские буквы')
                return
            }
            axios.post('/student/create', {
                name: this.name,
                email: this.email,
                password: this.password,
                class_id: this.groupId
            })
                .then(function (response) {
                    console.log(response);
                    alert('Студент создан!');
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
            <h1>Добавление студента</h1>
            <form @submit.prevent="addStudent" class="mt-4">
                <!-- Поле имя -->
                <div class="mb-3">
                    <label for="name" class="form-label">Ф.И.О.</label>
                    <input type="text" v-model="name" pattern="[А-Яа-я]+"  class="form-control" id="name" required>
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
