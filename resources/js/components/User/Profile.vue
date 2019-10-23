<template>
  <div>
    <form class="pb-2">
      <h1 class="mb-4">User Profile</h1>
      <div class="form-group form-inline">
        <label class="col-md-2 mr-2" for="IGN">Username</label>
        <input
          v-model="username"
          type="text"
          class="form-control col-md-8"
          placeholder="In Game Name"
        />
      </div>
      <div class="form-group form-inline">
        <label class="col-md-2 mr-2" for="FriendCode">Friend Code</label>
        <input
          v-model="friendcode"
          type="text"
          class="form-control col-md-8"
          placeholder="123456789"
        />
      </div>
    </form>
    <hr />
    <app-added-units></app-added-units>
    <div class="text-right col-md-12 mt-5">
      <button class="btn btn-primary" @click.prevent>Save All Changes</button>
      <button class="btn btn-link">Cancel</button>
    </div>
  </div>
</template>

<script>
import AddedUnits from "./AddedUnits";
export default {
  data() {
    return {
      username: "",
      friendcode: ""
    };
  },
  components: {
    "app-added-units": AddedUnits
  }
};
</script>