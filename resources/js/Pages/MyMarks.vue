<script setup>
import StudentsAuthLayout from "@/Layouts/StudentsAuthLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
<script>
export default {
    data() {
        return {
            student_id: '',
            subjects: [],
        };
    },
    mounted() {
        /*
        axios.get('api/user').then((response) => this.student_id = response.data.id);
        axios
            .get('api', {
                params: {
                    studentId: this.student_id, // здесь должен быть id пользователя
                },
            })
            .then((response) => {
                this.subjects = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
         */

        // тут должен быть код для получения данных из базы
        // используйте axios или fetch
    },
};
</script>
<template>
    <AuthenticatedLayout>
        <div>
            <h2>Оценки по предметам:</h2>
            <table>
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Оценка</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="subject in subjects" :key="subject.id">
                    <td>{{ subject.name }}</td>
                    <td>{{ subject.mark }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
