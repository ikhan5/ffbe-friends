<template> </template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            ballots: []
        };
    },
    created() {
        axios
            .get("/api/rankings")
            .then(res => {
                console.log(res.data);
            })
            .catch(err => {
                console.log(err.response);
                Swal.fire(
                    "Error, Kupo!",
                    "There was an error whilst loading the units, please try again later",
                    "error"
                );
            });
    }
};
</script>
