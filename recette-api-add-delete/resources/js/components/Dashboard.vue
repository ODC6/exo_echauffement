<script>
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, RadialLinearScale, ArcElement } from 'chart.js';
import axios from 'axios';
import { API_NODE_BASE } from '../constant';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, RadialLinearScale, ArcElement);

export default {
    components: { Bar, Pie },
    data() {
        return {
            loaded: false,
            loading: false,
            options: {
                responsive: true,
                maintainAspectRatio: false
            },
            comments: [],
            best: [],
            chartData: {
                labels: ['Nombre de user', 'Nombre de categorie', 'Nombre de plat'],
                datasets: [{
                    label: 'Nombre',
                    backgroundColor: ['#007BFF', '#28A745', '#FFC107'],
                    data: null
                }]
            },

            circularData: {
                labels: [],
                datasets: [{
                    label: 'Diagramme circulaire',
                    backgroundColor: ['#007BFF', '#28A745'],
                    data: []
                }]
            }
        };
    },
    mounted() {
        this.loadData();
        this.showRadar()
        this.loadDataComments()
        this.bestRanks()
    },
    methods: {
        async loadData() {
            this.loaded = false
            try {
                const response = await axios.get(`${API_NODE_BASE}/stats/data-count`);
                const data = response.data;
                this.chartData.datasets[0].data = [data[0].table1Count, data[0].table2Count, data[0].table3Count];

                this.loaded = true
            } catch (error) {
                console.log(error);
            }
        },

        async showRadar() {
            this.loading = false

            try {
                const response = await axios.get(`${API_NODE_BASE}/stats/comments-by-dish`);
                const data = response.data
                const commentCounts = Object.values(data).map(item => item.comment_count);
                const labelDish = Object.values(data).map(item => item.dish);

                this.circularData.datasets[0].data = commentCounts;
                this.circularData.labels = labelDish;


                this.loading = true
            } catch (error) {
                console.log(error);
            }
        },

        async loadDataComments() {
            try {
                const response = await axios.get(`${API_NODE_BASE}/stats/comments-index`)
                this.comments = response.data
            } catch (error) {
                throw error
            }
        },

        async bestRanks() {
            try {
                const response = await axios.get(`${API_NODE_BASE}/stats/best-rank`)
                this.best = response.data
                console.log(best);
            } catch (error) {
                console.log(error);
            }
        },

        truncateString(str, maxLength) {
            if (str.length > maxLength) {
                return str.slice(0, maxLength) + '...';
            }
            return str;
        }
    }
}
</script>




<template>
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <Bar v-if="loaded" :data="chartData" />
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <Pie v-if="loading" :data="circularData" :options="options" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Utilisateur</th>
                                    <th scope="col">Plat</th>
                                    <th scope="col">commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in comments" :key="index">
                                    <th scope="row">{{ row.name }}</th>
                                    <td>{{ row.dish_name }}</td>
                                    <td class="w-50 text-truncate">{{ truncateString(row.comment, 100) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom du plat</th>
                                    <th scope="col">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in best" :key="index">
                                    <th scope="row">{{ index }}</th>
                                    <td>{{ row.dish_name }}</td>
                                    <td>{{ row.average_mark }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>