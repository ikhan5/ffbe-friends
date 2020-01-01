<template>
    <div>
        <h2>Overall Rankings</h2>
        <strong>Results to be released at a later date</strong>
        <!-- <ul>
            <li v-for="(unit,index) in units" :key="index">
                {{unit.unit +" "+ unit.overall}}
            </li>
        </ul> -->
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            ballots: [],
            overall: [],
            units: []
        };
    },
    created() {
        axios
            .get("/api/results")
            .then(res => {
                this.units = res.data;
            })
            .catch(err => {
                Swal.fire(
                    "Error, Kupo!",
                    "There was an error whilst loading the units, please try again later",
                    "error"
                );
            });
    }
};
</script>
