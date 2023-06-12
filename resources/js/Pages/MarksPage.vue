<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,Link} from "@inertiajs/vue3";
</script>

<script>
import axios from "axios";
import * as XLSX from "xlsx";
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
            classes: [],
            subjects: [],
            students: [],
            marks: {},
            selectedMark:{},

            searchClass: '',
            searchSubject: '',

            selectedClass: 0,
            selectedSubject: 0,

            selectedMonth: right_now.getMonth() + 1,
            selectedYear: right_now.getFullYear(),

            possibleMarks: ["-","Б", "Н", "2", "3", "4", "5"],
        }
    },
    computed: {
        daysInMonth() {
            const year = this.selectedYear;
            const month = this.selectedMonth;
            const days = new Date(year, month, 0).getDate();
            return Array.from({ length: days }, (v, k) => k + 1);
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
    },
    mounted() {
        axios.get('/classes')
            .then(response => {
                this.classes = response.data;
            })
            .catch(error => console.log(error.message))
    },
    methods: {
        totalPass(row) {
            let totalPasses = 0;
            row.slice(1).forEach(char => {
                if (char === 'Б' || char === 'Н') {
                    totalPasses++;
                }
            });
            return totalPasses;
        },
        averageMarks(row) {
            // Обработать вход массива
            console.log(row.date);
            const numbers = row.slice(1).filter(c => !isNaN(c) && c >= 2 && c <= 5).map(Number);
            const sum = numbers.reduce((acc, val) => acc + val, 0);
            return (sum / numbers.length).toFixed(2);
        },
        exportToExcel() {
            // создаем новую рабочую книгу
            let wb = XLSX.utils.book_new();
            // формируем массив данных для листа
            let ws_data = [];
            let headers = [];
            headers.push('Студент');
            for (let r = 1;r < this.marks[0].length;r++){
                headers.push(r);
            }
            headers.push('Среднее');
            headers.push('Пропусков');
            ws_data.push(headers); // добавляем заголовки
            this.marks.forEach(row => {
                let answ = []
                answ[0] = row[0][1];
                let counter = 1;
                row.slice(1).forEach(r => { answ[counter] = row[counter]; counter++; })
                answ[counter] = this.averageMarks(row);
                counter++;
                answ[counter] = this.totalPass(row);
                console.log(answ);
                ws_data.push(answ);
            });
            // преобразуем данные в формат, понятный XLSX
            let worksheet = XLSX.utils.aoa_to_sheet(ws_data);
            //let worksheet = XLSX.utils.json_to_sheet(ws_data);
            // добавляем лист с данными в рабочую книгу
            XLSX.utils.book_append_sheet(wb, worksheet, `Оценки_${new Date().toDateString()}`);
            // сохраняем файл
            XLSX.writeFile(wb, `Оценки_${months[this.selectedMonth].name}_${new Date().toDateString()}.xlsx`);
        },
        updateTable(){
            this.marks = {};
            this.students = [];
            axios.post('/marksBySubject',{
                'subject_id': this.selectedSubject,
                'month': this.selectedMonth,
                'year': this.selectedYear,
            }).then(r => {
                this.marks = r.data.scores;
            }).catch(e=>console.log(e.message))
        },
        saveMark(event,day, studentID){
            axios.post('/marks/create',{
                case_id: this.selectedSubject,
                student_id: studentID,
                date: this.getDateInYMD(day),
                mark: event.target.value
            }).then(r=>console.log(r)).catch(err=>console.log(err.message));
        },
        showSubjects(){
            this.selectedSubject = 0;
            axios.get(`/classes/${this.selectedClass}/students`).then(response =>{
                this.students = response.data
            }).catch()
            axios.get(`/classes/${this.selectedClass}/subjects`).then(response =>{
                this.subjects = response.data
            }).catch()
        },
        getDateInYMD(day){
            let $ast = new Date(this.selectedYear, this.selectedMonth - 1, day+1).toISOString().slice(0, 10);
            return $ast;
        },
        resetDates(){
            this.selectedMonth = right_now.getMonth()+1;
            this.selectedYear = right_now.getFullYear();
            this.updateTable();
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
                        <div class="row-auto container h-auto">
                            <!-- Для классов столбец -->
                            <div class="p-3 rounded-1 border-white border-2 w-1/5 float-start">
                                <h5 class="text-center w-full text-white mb-2">Список классов</h5>
                                <input type="search" v-model="searchClass" class="h-7 w-full px-2 mb-4" placeholder="Введите название класса">
                                <select class="form-select rounded-5" v-model="selectedClass" @change="showSubjects">
                                    <option v-for="cls in filtredGroups" :key="cls.id" :value="cls.id">{{ cls.name }}</option>
                                </select>
                            </div>
                            <!-- Для предметов столбец -->
                            <div class="p-3 rounded-1 border-white border-2 w-1/5 float-start" v-if="selectedClass!==0">
                                <h5 class="text-center w-full text-white mb-2">Список предметов</h5>
                                <input type="search" v-model="searchSubject" class="h-7 w-full px-2 mb-3" placeholder="Введите название предмета">
                                <select class="form-select rounded-5" v-model="selectedSubject" @change="updateTable">
                                    <option v-for="subject in filtredSubjects" :key="subject.id" :value="subject.id" >
                                        {{ subject.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row container">
                            <!-- Для оценок столбец -->
                            <div class="p-3 rounded-1 border-white border-2 w-max" v-if="selectedClass!==0 && selectedSubject!==0">
                                <h5 class="text-center w-full text-white mb-2">Оценки</h5>
                                <div class="h-10 w-full px-2 mb-2 d-flex justify-content-between">
                                    <h1 class="text-white mx-auto px-4">Выберите месяц</h1>
                                    <select class="form-select rounded-5 mx-auto px-4" v-model="selectedMonth" @change="updateTable">
                                        <option v-for="month in months" :value="month.id" >{{ month.name }}</option>
                                    </select>
                                    <h1 class="text-white mx-auto px-4">Выберите год</h1>
                                    <select class="form-select rounded-5 px-4 mx-auto" v-model="selectedYear" @change="updateTable">
                                        <option v-for="year in ['2019','2020','2021','2022','2023']" :value="year" >{{ year }}</option>
                                    </select>
                                    <button class="btn btn-outline-danger mx-auto px-4" @click="resetDates">Сбросить</button>
                                    <div class="btn btn-outline-success hover:bg-green-500 px-4 rounded-5 mx-auto float-end">
                                        <button @click="exportToExcel">Экспортировать в Excel</button>
                                    </div>
                                </div>
                                <div class="scrollable-x table-responsive">
                                    <table class="table table-striped-columns text-white table-hover" id="table">
                                        <thead>
                                        <tr>
                                            <th>Студент</th>
                                            <th v-for="(day, index) in daysInMonth" :key="index">{{ day }}</th>
                                            <th>Средний балл</th>
                                            <th>Кол-во пропусков</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="row in marks" class="hover:bg-gray-400 hover:border-white">
                                            <td class="text-white">{{ row[0][1] }}</td>
                                            <td v-for="(day, index) in daysInMonth" :key="index" class="text-black">
                                                <select v-model="row[index+1]" v-on:change="saveMark($event, day, row[0][0])" class="text-black select-transparent">
                                                    <option v-for="ans in possibleMarks">{{ans}}</option>
                                                </select>
                                            </td>
                                            <td>{{ averageMarks(row) }}</td>
                                            <td>{{ totalPass(row) }}</td>
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
<style scoped>
.select-transparent {
    background-color: transparent;
    color: #ffffff; /* белый цвет текста */
    border: none; /* убираем границу */
    outline: none; /* убираем контур при клике */
}
.select-transparent option {
    background-color: rgba(0, 0, 0, 0.5); /* полупрозрачный цвет для опций*/
    color: #ffffff; /* белый цвет текста опций */
}
</style>
