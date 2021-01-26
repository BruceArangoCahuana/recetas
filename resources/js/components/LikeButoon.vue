<template>
        <div>
            <span class="like-btn" @click="likeReceta" :class="{'like-active':isActive}"></span>
            <p>{{cantidadLikes}} Les gusto esta receta</p>
        </div>
</template>
<script>
        export default {
            props:['recetaId','like','likes'],
            data:function(){
                return{
                    isActive: this.like,
                    totalLikes: this.likes
                }
            },
            mounted(){

            },
            methods:{
                likeReceta(){
                    axios.post('/recetas/' + this.recetaId)
                        .then(respuesta=>{
                            //revisamos por los attachmen
                            if(respuesta.data.attached.length>0){
                                this.$data.totalLikes++;
                            }else{
                                this.$data.totalLikes--;
                            }
                            this.isActive = !this.isActive
                        })
                        .catch(error=>{
                            if(error.response.status === 401){
                                window.location = '/register';
                            }
                        })
                }
            },
            computed:{
                cantidadLikes: function(){
                    return this.totalLikes
                }
            }

        }
</script>