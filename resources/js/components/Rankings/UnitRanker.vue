<template>
    <div>
        <h1 class="row mt-3">Unit Ranker</h1>
        <hr />
        <div class="row ml-1">
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    v-model="rankType"
                    id="overallRank"
                    value="overallRank"
                />
                <label class="form-check-label" for="overallRank"
                    >Top 15 Ranking</label
                >
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    v-model="rankType"
                    id="roleRank"
                    value="roleRank"
                />
                <label class="form-check-label" for="roleRank"
                    >Role Ranking (Top 5 for Each)</label
                >
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input"
                    type="radio"
                    v-model="rankType"
                    id="results"
                    disabled
                    value=""
                />
                <label class="form-check-label" for="results"
                    >Results (Date: TBD)</label
                >
            </div>
        </div>
        <hr />
        <keep-alive v-if="rankType === 'overallRank'">
            <app-overall-rank></app-overall-rank>
        </keep-alive>
        <keep-alive v-else>
            <app-role-rank></app-role-rank>
        </keep-alive>
    </div>
</template>

<script>
import OverallRank from "./Overall";
import RoleRank from "./Role";
export default {
    data() {
        return {
            rankType: "overallRank"
        };
    },
    components: {
        "app-overall-rank": OverallRank,
        "app-role-rank": RoleRank
    }
};
</script>
