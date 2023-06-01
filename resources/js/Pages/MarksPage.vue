<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,Link} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
</script>

<script>
export default {
    data() {
        return {
            users: [],
            students: [],
            classes: [],
            selectedClass: null,
            selectedOption: 'current',
            months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        }
    },
    computed: {
        daysInMonth() {
            const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const daysInMonth = new Date(year, month, 0).getDate();
            const daysArray = [];
            for (let i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            return daysArray;
        }
    },
    mounted() {
        axios.get('/api/students').then(response => {
            this.students = response.data
        });

    },
    methods: {
        getAttendance(attendance, day) {
            const attendanceObject = attendance.find(a => new Date(a.date).getDate() === day);
            return attendanceObject ? attendanceObject.status : "-";
        },
        showStudents(classId) {
            this.selectedClass = this.classes.find(cls => cls.id === classId);
        },
        updateData() {
            this.data = this.options[this.selectedOption];
        },
    }
}
</script>

<template>
    <Head title="Выставление оценок"></Head>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <table>
                        <tr>
                            <td>
                                <div class="scrollable">
                                    <h1>Список классов</h1>
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="cls in classes" :key="cls.id" @click="showStudents(cls.id)">
                                            <td>{{ cls.id }}</td>
                                            <td>{{ cls.name }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <td >
                                <h2 v-if="selectedClass">Студенты класса "{{ selectedClass.name }}"</h2>
                                <ul v-if="selectedClass">
                                    <li v-for="student in students" :key="student.id">{{ student.name }}</li>
                                </ul>
                            </td>
                            <td>
                                <div>
                                    <select v-model="selectedOption" @change="updateData">
                                        <option value="option1"></option>
                                        <option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option>
                                    </select>
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Студент</th>
                                            <th v-for="(day, index) in daysInMonth" :key="index">{{day}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(student, index) in students" :key="index">
                                            <td>{{student.name}}</td>
                                            <td v-for="(day, index) in daysInMonth" :key="index">{{getAttendance(student.marks, day)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
