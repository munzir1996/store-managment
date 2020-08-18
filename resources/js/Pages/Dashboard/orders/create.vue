<template>
    <layout>

        <div class="mt-8">
            <div class="flex">
                <h2 class="text-3xl text-indigo-500 font-bold"> خدمة العملاء /<span class="text-gray-700"> أنشاء طلب
                    </span></h2>
            </div>
            <!-- md:max-w-3xl -->

            <base-panel class=" mt-4">
                <div class="flex">
                    <button class="mx-1 bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                        All
                    </button>
                    <button v-for="category in categories" :key="category.id" @click="getCategoryProducts(category.id)"
                        class="mx-1 bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                        {{category.name}}
                    </button>
                </div>
                <div class="flex">
                    <button v-for="sub_category in sub_categories" :key="sub_category.id"
                        class="mx-1 my-1 bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                        {{sub_category.name}}
                    </button>
                </div>
                <!-- <form @submit.prevent="submit"> -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                    <div v-for="(product, key) in products" :key="key"
                        class="mt-4 flex flex-col justify-center items-center max-w-sm mx-auto">
                        <div>
                            <img class="bg-gray-300 h-64 w-full rounded-lg shadow-md bg-cover bg-center"
                                :src="product.image">
                        </div>

                        <div class="w-56 md:w-64 bg-white -mt-10 shadow-lg rounded-lg overflow-hidden">
                            <h3 class="py-2 text-center font-bold uppercase tracking-wide text-gray-800">
                                {{product.name}}
                            </h3>
                            <p class="py-2 text-center font-bold uppercase tracking-wide text-gray-800">الوزن :
                                {{product.weight}}</p>
                            <div class="flex items-center justify-between py-2 px-3 bg-gray-200">
                                <span class="text-gray-800 font-bold ">SDG {{product.total_price}}</span>
                                <div v-if="!product.selected">
                                    <button @click="addProduct(key)"
                                        class=" bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                                        Add to cart
                                    </button>
                                </div>
                                <div v-else>
                                    <button @click="increment(key)"
                                        class=" bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                                        +
                                    </button>
                                    <button
                                        class=" bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                                        {{product.quantity}}
                                    </button>
                                    <button @click="decrement(key)"
                                        class="bg-gray-800 text-xs text-white px-2 py-1 font-semibold rounded uppercase hover:bg-gray-700">
                                        -
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- </form> -->
            </base-panel>
            <base-panel class=" mt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <base-input label="رقم العميل" name="customer_phone" v-model="form.customer_phone" :error="$page.errors.customer_phone" required></base-input>
                    </div>
                    <div>
                        <base-input label=" رقم العميل الأضافي" name="customer_alt_phone" v-model="form.customer_alt_phone" :error="$page.errors.customer_alt_phone"></base-input>
                    </div>
                    <div>
                        <base-input label="عنوان العميل" name="customer_address" v-model="form.customer_address" :error="$page.errors.customer_address" required></base-input>
                    </div>
                    <div>
                        <base-input label="خصم" name="discount" v-model="form.discount" :error="$page.errors.discount"></base-input>
                    </div>
                    <div>
                        <p class="text-gray-700">
                         المبلغ الكلى : SDG {{total_price}}
                        </p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <base-button @click.prevent="submitOrder" primary>أنشاء طلب</base-button>
                    </div>
                </div>
            </base-panel>

        </div>

    </layout>
</template>

<script>
    import Layout from "../../../Shared/Layout";

    export default {
        components: {
            Layout
        },
        props: ['products', 'sub_categories', 'categories'],
        computed: {

        },
        data() {
            return {
                form: {
                    customer_phone: '',
                    customer_alt_phone: '',
                    category_id: '',
                    customer_address: '',
                    discount: '',
                },
                orderDetails: [],
                total_price: 0,
            }
        },
        created() {

        },
        methods: {
            addProduct(index) {
                console.log(index)
                this.products[index].selected = !this.products[index].selected;
                this.products[index].quantity++;
                this.total_price += parseFloat(this.products[index].total_price);
            },
            increment(index) {
                ++this.products[index].quantity;
                this.total_price += parseFloat(this.products[index].total_price);
            },
            decrement(index) {
                --this.products[index].quantity;
                this.total_price -=  parseFloat(this.products[index].total_price);
                if (this.products[index].quantity == 0) {
                    this.products[index].selected = !this.products[index].selected;
                }
            },
            submit() {

                this.$inertia.post('/dashboard/products', formData);
            },

            getCategoryProducts(id) {

                axios.get('/dashboard/get/category/products/' + id)
                .then(res => {
                    console.log(res);
                    this.products = res.data.products;
                    this.sub_categories = res.data.subcategories;
                })
                .catch(error => {
                    console.log(error)
                });

            },

            submitOrder() {

                this.orderDetails = this.products.filter(product => product.selected == true);
                console.log(this.orderDetails);
                // axios.get('/dashboard/get/subcategories/' + id)
                // .then(res => {
                //     console.log(res);
                //     this.subcategories = res.data
                // })
                // .catch(error => {
                //     console.log(error)
                // });

            }

        }
    }

</script>
