<template>
  <div>
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">SK Mengajar</h3>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">Home</a>
          </li>
          <li class="breadcrumb-item">
            <router-link :to="{name:'sk-mengajar'}">SK Mengajar</router-link>
          </li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </div>
    </div>

    <div class="container-fluid">
      <!-- <v-loader></v-loader> -->
      <div class="card">
        <div class="card-body vs-con-loading__container">
          <h3 class="text-center mb-5">Tambah Setting SK Mengajar</h3>
          <vs-row>
            <vs-col
              vs-offset="3"
              v-tooltip="'col - 6'"
              vs-type="flex"
              vs-justify="center"
              vs-align="center"
              vs-w="6"
            >
              <vs-input style="width:100%" size="large" label-placeholder="No SK" />
            </vs-col>
          </vs-row>

          <vs-row class="mt-3">
            <vs-col
              vs-offset="3"
              v-tooltip="'col - 6'"
              vs-type="flex"
              vs-justify="center"
              vs-align="center"
              vs-w="6"
            >
              <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6">
                <vs-select
                  autocomplete
                  @input-changed
                  style="width:100%"
                  label="Tahun Ajaran"
                  v-model="tahunajaran"
                >
                  <vs-select-item
                    :key="index"
                    :value="item.value"
                    :text="item.text"
                    v-for="(item,index) in options3"
                  />
                </vs-select>
              </vs-col>
              <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="6"></vs-col>
            </vs-col>
          </vs-row>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tahunajaran: 0,
      options3: [
        { text: "Red", value: 1 },
        { text: "Green", value: 2 },
        { text: "Blue", value: 3 },
        { text: "Purple", value: 4 }
      ]
    };
  }
};
</script>