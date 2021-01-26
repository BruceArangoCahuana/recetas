<template>
    <span v-text="formatearFeacha"></span>
</template>

<script>
    export default{
        props:['fecha'],
        computed:{
            formatearFeacha(){
                return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY');
            }
        }
    }
</script>