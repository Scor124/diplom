<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,Link} from "@inertiajs/vue3";
import StudentForMarksSelector from "@/Components/StudentForMarksSelector.vue";
</script>

<script>
import axios from "axios";
import StudentForMarksSelector from "@/Components/StudentForMarksSelector.vue";
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
right_now.setMonth(right_now.getMonth()+1);
export default {
    data() {
        return {
            classes: [],
            subjects: [],
            students: [],
            marks: [],

            searchClass: '',
            searchSubject: '',

            selectedClass: 0,
            selectedSubject: 0,

            selectedMonth: right_now.getMonth(),
            selectedYear: right_now.getFullYear(),

        }
    },
    computed: {
        daysInMonth() {
            const year = this.selectedYear;
            const month = this.selectedMonth;
            const daysInMonth = new Date(year,month,0).getDate();
            const daysArray = [];
            for (let i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            return daysArray;
        },
        filtredGroups() {
            if (this.searchClass === ''){
                return this.classes;
            }
            return this.classes.filter(c => c.name.toLowerCase().includes(this.searchClass.toLowerCase()));
        },
        filtredSubjects(){
            if (this.searchSubject === ''){
                return this.subjects
            }
            return this.subjects.filter(subject => subject.name.toLowerCase().includes(this.searchSubject.toLowerCase()))
        },
        getDateInYMD(day){
            let $ast = new Date(this.selectedYear, this.selectedMonth - 1, day+1).toISOString().slice(0, 10).toString()
            return $ast;
        },
    },
    mounted() {
        axios.get('/classes')
            .then(response => {
                this.classes = response.data;
            })
            .catch(error => console.log(error.message))
    },
    methods: {

        showSubjects(classId){
            this.selectedSubject = null;
            this.selectedClass = classId;
            axios.get(`/classes/${classId}/students`).then(response =>{
                this.students = response.data
            }).catch()
            axios.get(`/classes/${classId}/subjects`).then(response =>{
                this.subjects = response.data
            }).catch()
        },

        resetDates(){
            this.selectedMonth = right_now.getMonth();
            this.selectedYear = right_now.getFullYear();
        },
    }
}
</script>

<template>
    <Head title="Выставление оценок"></Head>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 container">
                        <div class="row container">
                            <!-- Для классов столбец -->
                            <div class="col-3 p-3 rounded-1 border-white border-2 w-1/5">
                                <h5 class="text-center w-full text-white mb-2">Список классов</h5>
                                <input type="search" v-model="searchClass" class="h-7 w-full px-2 mb-4" placeholder="Введите название класса">
                                <div class="scrollable-y">
                                    <table class="text-gray-50 table">
                                        <thead>
                                            <tr>
                                                <th>Название</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cls in filtredGroups" :key="cls.id">
                                                <td>
                                                    <button class="btn-link w-full" @click="showSubjects(cls.id)">{{ cls.name }}</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Для предметов столбец -->
                            <div class="col-3 p-3 rounded-1 border-white border-2 w-1/5" v-if="selectedClass!==0">
                                <h5 class="text-center w-full text-white mb-2">Список предметов</h5>
                                <input type="search" v-model="searchSubject" class="h-7 w-full px-2 mb-3" placeholder="Введите название предмета">
                                <div class="w-full p-4 justify-center">
                                    <select class="form-select rounded-5" v-model="selectedSubject" @change="subjectChanged">
                                        <option v-for="subject in filtredSubjects" :key="subject.id" :value="subject.id" >
                                            {{ subject.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Для оценок столбец -->
                            <div class="col-6 p-3 rounded-1 border-white border-2 w-3/5" v-if="selectedClass!==0 && selectedSubject!==0">
                                <h5 class="text-center w-full text-white mb-2">Оценки</h5>
                                <div class="h-10 w-full px-2 mb-2 d-flex justify-content-between">
                                    <h1 class="text-white mx-auto">Выберите месяц</h1>
                                    <select class="form-select rounded-5 mx-auto" v-model="selectedMonth" @change="">
                                        <option v-for="month in months" :value="month.id" >{{ month.name }}</option>
                                    </select>
                                    <h1 class="text-white mx-auto">Выберите год</h1>
                                    <select class="form-select rounded-5 mx-auto" v-model="selectedYear">
                                        <option v-for="year in ['2019','2020','2021','2022','2023']" :value="year" >{{ year }}</option>
                                    </select>
                                    <button class="btn btn-outline-danger mx-auto" @click="resetDates">Сбросить</button>
                                </div>
                                <div class="scrollable-x table-responsive">
                                    <table class="table table-striped-columns text-white" id="table">
                                        <thead>
                                            <tr>
                                                <th>Студент</th>
                                                <th v-for="(day, index) in daysInMonth" :key="index">{{ day }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="student in students" :key="student.id">
                                                <td>{{ student.name }}</td>
                                                <td v-for="day in daysInMonth">
                                                    <StudentForMarksSelector
                                                        :student_id="student.student.id"
                                                        :case_id="selectedSubject"
                                                        :date="this.getDateInYMD(day)"
                                                    />
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
