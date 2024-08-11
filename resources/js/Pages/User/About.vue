<script setup>
import UserLayout from './Layouts/UserLayout.vue'
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
    <title>{{ 'About | Abaya' }}</title>
</Head>
<UserLayout>
  <section class="">
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="lg:text-center">
                <h2
                    class="font-heading mb-4 bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg md:w-64 md:mx-auto text-xs font-semibold tracking-widest text-black uppercase title-font">
                    Why Choose Abaya?
                </h2>
                <p class="font-heading mt-2 text-3xl leading-8 font-semibold tracking-tight text-gray-900 sm:text-4xl">
                    Quality, Elegance, and Tradition in Every Stitch.
                </p>
                <p class="mt-4 max-w-2xl text-lg text-gray-500 lg:mx-auto">
                    Discover the beauty of Islamic clothing crafted from premium Zoom fabric, imported from Dubai. We bring you the finest Abayas that blend tradition with modernity.
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <img src="https://images.stockcake.com/public/7/9/2/7924c83f-efde-47b7-8a9a-a12818e3724f_large/vibrant-fabric-array-stockcake.jpg" alt="Premium Quality">
                            </div>
                            <p class="font-heading ml-16 text-lg leading-6 font-bold text-gray-700">Premium Quality</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Our Abayas are crafted from the finest Zoom fabric, ensuring unmatched quality and durability.
                        </dd>
                    </div>
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <img src="https://images.stockcake.com/public/8/0/4/804ff7fc-28f0-4d2d-9180-3bf1b963178d_large/flower-shop-serenity-stockcake.jpg" alt="Elegant Designs">
                            </div>
                            <p class="font-heading ml-16 text-lg leading-6 font-bold text-gray-700">Elegant Designs</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Our designs are a perfect blend of tradition and modernity, offering you elegance in every piece.
                        </dd>
                    </div>
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <img src="https://images.stockcake.com/public/1/7/5/175cfbd4-059f-457e-b5c2-c3764276cae6_large/nighttime-gas-prices-stockcake.jpg" alt="Affordable Prices">
                            </div>
                            <p class="font-heading ml-16 text-lg leading-6 font-bold text-gray-700">Affordable Prices</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Experience luxury at prices that won't break the bank. We believe in making elegance accessible.
                        </dd>
                    </div>
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <img src="https://images.stockcake.com/public/a/d/4/ad46bedc-a59a-421f-9970-96e3bee773e1_large/joyful-satisfaction-display-stockcake.jpg" alt="Customer Satisfaction">
                            </div>
                            <p class="font-heading ml-16 text-lg leading-6 font-bold text-gray-700">Customer Satisfaction</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            We prioritize your satisfaction, offering seamless shopping experiences and top-notch customer service.
                        </dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</section>

</UserLayout>
</template>