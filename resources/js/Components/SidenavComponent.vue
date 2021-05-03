<template>
    <aside>
        <ul class="list-unstyled">
            <li class="list-group-item border-0 p-0" v-for="(item,key) in familias">
                <a :href="'#categoria_'+key" data-toggle="collapse" class="d-flex fw-medium align-items-center p-2 border-bottom fwb700 " :class="familiaId == item.id ? 'bg-primario text-white' : 'text-primario'">
<!--                    <span onclick="location.href='{{ route('producto.subfamilias',$item->slug) }}'"></span>-->
                    {{ item.title }}

<!--                    <i class="fas fa-plus ml-auto" style="font-size: 8px"></i>-->
                </a>
                <ul class="list-unstyled collapse " :class="familiaId == item.id ? 'show ' : ''" style="background-color: #858592" :id="'categoria_'+key">
                    <li class="p-3 fw-medium border-bottom pl-3 pr-2" :style="productoId == producto.id ? 'background-color: #1391FF;' : 'text-white'" v-for="producto in item.productos"><a :href="producto.ruta" class="text-white">{{ producto.title }} </a></li>
                </ul>
            </li>
        </ul>
    </aside>
</template>

<script>
    import Login from '@/Components/LoginComponent'
    export default {
        components: {
          'login-component': Login
        },
        props:['familias','familiaId','productoId'],
        data() {
            return {

            }
        },
        methods: {

        }
    }
</script>
