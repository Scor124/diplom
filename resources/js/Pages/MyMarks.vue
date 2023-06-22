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
        daysInMonth() {
            const year = this.selectedYear;
            const month = this.selectedMonth;
            const days = new Date(year, month-1, 0).getDate();
            return Array.from({ length: days }, (v, k) => k + 1);
        },
        filtredSubjects(){
            if (this.searchSubject === ''){
                return this.subjects
            }
            return this.subjects.filter(subject => subject.name.toLowerCase().includes(this.searchSubject.toLowerCase()))
        },

    },
    methods:{
        totalPass(row) {
            let totalPasses = 0;
            row.slice(1).forEach(char => {
                if (char === 'Б' || char === 'Н') {
                    totalPasses++;
                }
            });
            return totalPasses;
        },
        averageMark(row){
            const numbers = row.slice(1).filter(c => !isNaN(c) && c >= 2 && c <= 5).map(Number);
            const sum = numbers.reduce((acc, val) => acc + val, 0);
            return (sum / numbers.length).toFixed(2);
        },
        getMarkForSubject(){
            this.updateTable()
        },
        updateTable(){
            this.marks = [];
            axios.post('/marks/byStudentAndDate',{
                    'studentID': this.user.id,
                    'subject_id': this.selectedSubject,
                    'month': this.selectedMonth,
                    'year': this.selectedYear,
            }).then(r => {
                this.marks = r.data
            }).catch(e => e.message)
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
                                <option v-for="subj in filtredSubjects" :key="subj.id" :value="subj.id">
                                    {{ subj.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col px-4 w-auto" v-if="selectedSubject!==null">
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
                                    <tr v-for="(day, index) in daysInMonth" :key="index" class="bg-transparent text-white">
                                        <th >{{ day }}</th>
                                        <th >{{ marks[index+1] }}</th>
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
                                    <p class="mt-3 text-white">Всего пропусков: {{ totalPass(marks) }}</p>
                                    <p class="mt-3 text-white">Средняя оценка: {{ averageMark(marks) }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
