<script setup>
const props = defineProps({
    groupId: {
        type: Number
    }
});
</script>
<script>
import axios from "axios";
export default{
    data(){
        return{
            name: '',
            class: this.groupId,
            searchQuery: '',
            teachers: [],
            selectedTeacher: 0,
        }
    },
    mounted(){
        axios.get('/teachers')
            .then((response) => this.teachers = response.data)
            .catch((error) => console.log(error.message))
    },
    methods: {

        addSubject() {
            if (!/[А-Яа-я]+$/.test(this.name)) {
                alert('Введите русские буквы')
                return
            }
            axios.post('/subject/create', {
                name: this.name,
                classID: this.groupId,
                teacherID: this.selectedTeacher.id,
            })
                .then(function (response) {
                    console.log(response);
                    alert('Предмет создан!');
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
    computed: {
        filteredTeachers() {
            if (this.searchQuery === ''){
                return this.teachers
            }
            return this.teachers.filter((teacher) =>
                teacher.user.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            )
        },
    }
}
</script>
<template>
    <div class="container-fluid text-center">
        <div class="bg-transparent container mt-5">
            <h1>Добавление предмета</h1>
            <form @submit.prevent="addSubject" class="mt-4">
                <!-- Поле имя -->
                <div class="mb-3">
                    <label for="name" class="form-label">Название предмета</label>
                    <input type="text" v-model="name" pattern="[А-Яа-я]+" class="form-control" id="name" required>
                </div>
                <!-- Поле email -->

                <div class="mb-3">
                    <input type="text" v-model="searchQuery" @input="filteredTeachers" class="form-control" placeholder="Поиск учителя по ФИО...">
                    <select class="form-select mt-2" v-model="selectedTeacher" required>
                        <option v-for="teacher in filteredTeachers" :key="teacher.id" :value="teacher" selected>{{ teacher.user.name }}</option>
                    </select>
                </div>

                <!-- Кнопка добавления пользователя -->
                <button type="submit" class="btn btn-primary">Добавить</button>
            </form>
        </div>
    </div>
</template>
