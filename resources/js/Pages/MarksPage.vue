<script setup>

</script>

<script>
export default {
    data() {
        return {
            users: [],
            students: [],
            classes: []
        }
    },
    mounted() {
        axios.get('/api/data')
            .then(response => {
                this.users = response.data.users;
                this.students = response.data.students;
                this.classes = response.data.classes;
            });
    }
}
</script>

<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table>
                <tr>
                    <td>
                        <div class="scrollable " style="height: 200px; overflow-y: scroll;">
                            <!— Таблица со скроллингом —>
                        </div>
                    </td>
                    <td>
                        <div></div> <!— Пустой div —>
                    </td>
                    <td>
                        <div></div> <!— Пустой div —>
                    </td>
                </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
