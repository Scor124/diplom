<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    user:{
        type: Object,
    }
});
</script>
<script>
import {usePage} from "@inertiajs/vue3";
import axios from "axios";
const months = [
    { id: 1, name: 'Январь' },
    { id: 2, name: 'Февраль' },
    { id: 3, name: 'Март' },
    { id: 4, name: 'Апрель' },
    { id: 5, name: 'Май' },
    { id: 6, name: 'Июнь' },
    { id: 7, name: 'Июль' },
    { id: 8, name: 'Август' },
    { id: 9, name: 'Сентябрь' },
    { id: 10, name: 'Октябрь' },
    { id: 11, name: 'Ноябрь' },
    { id: 12, name: 'Декабрь' }
];
const right_now = new Date();
export default {
    data() {
        return {
            subjects: [],
            marks: [],
            selectedSubject: null,
            selectedMonth: right_now.getMonth() + 1,
            selectedYear: right_now.getFullYear(),
            searchSubject: '',
        };
    },
    mounted() {

        axios.get(`/classes/${this.user.class_id}/subjects`)
            .then(response => {
                this.subjects = response.data;
            })
            .catch(error => console.log(error.message))
    },
    computed:{
        filtredSubjects(){
            if (this.searchSubject === ''){
                return this.subjects
            }
            return this.subjects.filter(subject => subject.name.toLowerCase().includes(this.searchSubject.toLowerCase()))
        },
        averageMark(){
            return 0;
        },
    },
    methods:{
        getMarkForSubject(){
            axios.get('').then().catch()
        },
        updateTable(){

        },
    },
};
</script>
<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <div class="row border-1 w-full">
                    <div class="col-3 m-2">
                        <div class="w-full" >
                            <input class="w-full m-2" type="search" placeholder="Поиск предмета" v-model="searchSubject">
                            <select class="form-select w-full m-2" v-model="selectedSubject" @change="getMarkForSubject">
                                <option v-for="subj in filtredSubjects" :key="subj.id">
                                    {{ subj.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col px-4 w-auto" >
                        <div class="row">
                            <div class="col-6 p-2">
                                <table class="table text-white bg-transparent p-1">
                                    <thead>
                                    <tr class="text-center">
                                        <th>День</th>
                                        <th>Оценка</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="row">
                                        <th class="col"></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <div class="m-2 p-2">
                                    <div class="col">
                                        <div class="w-auto row">
                                            <h1 class="text-white col-4 my-auto">Выберите месяц</h1>
                                            <select class="form-select bg-gray-400 col" v-model="selectedMonth" @change="updateTable">
                                                <option v-for="month in months" :value="month.id" >{{ month.name }}</option>
                                            </select>
                                        </div>
                                        <div class="w-auto row">
                                            <h1 class="text-white col-4 my-auto">Выберите год</h1>
                                            <select class="form-select bg-gray-400 col" v-model="selectedYear" @change="updateTable">
                                                <option v-for="year in ['2019','2020','2021','2022','2023']" :value="year" >{{ year }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <select  >
                                        <option disabled selected>Выберите четверть</option>
                                        <option></option>
                                    </select>
                                    <p class="mt-3 text-white">Всего пропусков: </p>
                                    <p class="mt-3 text-white">Средняя оценка: </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
