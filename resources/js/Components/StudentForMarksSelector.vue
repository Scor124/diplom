<script setup>
import axios from "axios";
defineProps({
    case_id: Number,
    date: String,
    student_id: Number
})
</script>
<script>
import axios from "axios";
export default {
    data(){
        return{
            Mark: null,
        }
    },
    mounted() {
        this.getMark();
    },
    computed(){
    },
    methods: {
        getMark(){
            axios.get('/markses',{
                params:{
                    student_id: this.student_id,
                    case_id: this.case_id,
                    date: this.date,
                }
            }).then(r=> {
                this.Mark = r.data.mark;
            }).catch(e=>console.log(e.message))
        },
        saveMark(event){
            axios.post('/marks/create',{
                case_id: this.case_id,
                student_id: this.student_id,
                date: this.date,
                mark: event.target.value
            }).then(r=>console.log(r)).catch(err=>console.log(err.message));
        }
    }
}
</script>
<template>
    <select v-model="Mark" v-on:change="saveMark($event)" class="text-black">
        <option value="-">-</option>
        <option>Н</option>
        <option>Б</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
    </select>
</template>
