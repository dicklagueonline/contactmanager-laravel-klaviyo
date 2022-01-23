<template>
  <div
    class="modal fade"
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1"
    aria-hidden="true"
    ref="modal"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ steps[step] }}</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click.prevent="closeModal"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-center" v-if="step === 'load'">
            <div class="col-md-10">
              <form accept-charset="utf-8" enctype="multipart/form-data">
                <div class="form-group row">
                  <div
                    class="custom-file"
                    v-bind:class="{
                      'is-invalid': !!errors && !!errors.csv,
                    }"
                  >
                    <input
                      ref="fileinput"
                      type="file"
                      class="custom-file-input"
                      v-bind:class="{
                        'is-invalid': !!errors && !!errors.csv,
                      }"
                      name="file"
                      id="file"
                      accept=".csv"
                      @change="handleFileInput"
                    />
                    <label
                      ref="filelabel"
                      class="custom-file-label"
                      for="file"
                      >{{ fileInputLabel }}</label
                    >
                  </div>
                  <div class="invalid-feedback" v-if="!!errors && !!errors.csv">
                    <strong v-for="(error, index) in errors.csv" :key="index">{{
                      error
                    }}</strong>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="row justify-content-center" v-if="step === 'map'">
            <div class="col-md-10">
              <div
                class="form-group row"
                v-for="(fieldlabel, fieldkey) in fields"
                :key="fieldkey"
              >
                <label class="col-md-4 col-form-label text-md-right">{{
                  fieldlabel
                }}</label>

                <div class="col-md-6">
                  <select
                    v-model="field_column_map[fieldkey]"
                    class="custom-select custom-select-sm"
                    v-bind:class="{
                      'is-invalid': !!errors && !!errors[fieldkey],
                    }"
                  >
                    <option value="">Select Column</option>
                    <option
                      v-for="(column, index) in columns"
                      :key="index"
                      :value="column"
                    >
                      {{ column }}
                    </option>
                  </select>
                  <div
                    class="invalid-feedback"
                    v-if="!!errors && !!errors[fieldkey]"
                  >
                    <strong
                      v-for="(error, index) in errors[fieldkey]"
                      :key="index"
                      >{{ error }}</strong
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center" v-if="step === 'review'">
            <div class="col-md-12">
              <div class="row">
                <div class="col-3">File</div>
                <div class="col-9">{{ importFileData.filename }}</div>
              </div>

              <div class="row">
                <div class="col-3">File Size</div>
                <div class="col-9">
                  {{ importFileData.filesize | formatSize }}
                </div>
              </div>

              <div class="row">
                <div class="col-3">Rows</div>
                <div class="col-9">{{ importFileData.rows }}</div>
              </div>

              <div class="row wrap mt-2">
                <div class="col-12">Column Mapping</div>
                <div class="col-12">
                  <table class="table table-sm table-bordered">
                    <thead>
                      <tr>
                        <td>COLUMN</td>
                        <td>CONTACT FIELD</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(
                          key, field
                        ) in importFileData.mapped_import_fields"
                        :key="key"
                      >
                        <td>{{ key | formatFieldName }}</td>
                        <td>{{ field | formatFieldName }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center" v-if="step === 'queue'">
            <div class="col-md-12">
              <p>
                Import file has been added to our queue and will the start the
                import shortly. We will notify you through email once the import
                is finished.
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            v-if="['load', 'queue'].includes(step)"
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click.prevent="closeModal"
          >
            Close
          </button>
          <button
            v-if="!['load', 'queue'].includes(step)"
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click.prevent="cancelImport"
          >
            Cancel
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click.prevent="UploadFile"
            v-if="step === 'load'"
          >
            Load File
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click.prevent="mapImportField"
            v-if="step === 'map'"
          >
            Save Mapping
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click.prevent="startImport"
            v-if="step === 'review'"
          >
            Import
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { preselect } from "../utils/string";

export default {
  props: {
    value: false,
    userId: {
      type: Number | String,
      required: true,
    },
  },
  data() {
    return {
      modalElem: null,
      errors: {},
      file: null,
      label: "Choose csv file to import",

      loading: false,
      loading_progress: 0,

      fields: {},
      columns: {},

      field_column_map: {},

      importFileData: {},

      steps: {
        load: "Upload File",
        map: "Map Contact-Import Fields",
        review: "Import Details",
        queue: "Added to Queue",
      },
      step: "load",
    };
  },
  computed: {
    fileInputLabel: function () {
      return this.file ? this.file.name : this.label;
    },
  },
  watch: {
    value(a) {
      if (a) {
        $(this.modalElem).modal("show");
      } else {
        $(this.modalElem).modal("hide");
      }
    },
    loading_progress(a) {
      console.log("Loading: " + a + "%");
    },
  },
  methods: {
    closeModal: function () {
      this.errors = {};
      this.file = null;
      this.step = "load";
      this.columns = {};
      this.fields = {};
      this.field_column_map = {};
      this.upload_progress = 0;
      this.$emit("input", false);
    },
    handleFileInput: function (event) {
      console.log(event.target.files);
      const files = event.target.files;
      if (files.length > 0) {
        this.file = files[0];
      }
    },
    UploadFile: function () {
      if (this.file) {
        let formData = new FormData();
        formData.append("csv", this.file);

        axios
          .post(`/import/contact/upload`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
              Accept: "application/vnd.api+json",
            },
            onUploadProgress: function (progressEvent) {
              this.loading_progress = parseInt(
                Math.round((progressEvent.loaded / progressEvent.total) * 100)
              );
            }.bind(this),
          })
          .then((xhr) => {
            this.errors = null;

            this.importFileData = xhr.data.data;
            this.columns = xhr.data.data.headers;
            this.fields = xhr.data.data.fields;

            Object.keys(this.fields).forEach((key) => {
              this.field_column_map[key] = preselect(key, this.columns);
            });

            this.step = "map";
          })
          .catch((err) => {
            this.errors = !err.response ? err.response.data.errors : {};
            console.log(err);
          });
      } else {
        this.errors = {
          csv: ["CSV file is required."],
        };
      }
    },
    mapImportField: function () {
      let formdata = new FormData();

      Object.keys(this.field_column_map).forEach((key) => {
        formdata.append(key, this.field_column_map[key]);
      });

      axios
        .post(`/import/contact/${this.importFileData.id}/map`, formdata, {
          headers: {
            "Content-Type": "multipart/form-data",
            Accept: "application/vnd.api+json",
          },
          onUploadProgress: function (progressEvent) {
            this.loading_progress = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(this),
        })
        .then((xhr) => {
          this.errors = null;
          this.importFileData = xhr.data.data;
          this.step = "review";
        })
        .catch((err) => {
          this.errors = !err.response ? err.response.data.errors : {};
          console.log(err);
        });
    },
    startImport: function () {
      axios
        .post(
          `/import/contact/${this.importFileData.id}/process`,
          {},
          {
            headers: {
              "Content-Type": "multipart/form-data",
              Accept: "application/vnd.api+json",
            },
            onUploadProgress: function (progressEvent) {
              this.loading_progress = parseInt(
                Math.round((progressEvent.loaded / progressEvent.total) * 100)
              );
            }.bind(this),
          }
        )
        .then((xhr) => {
          this.error = null;
          this.step = "queue";
        })
        .catch((err) => {
          this.errors = !!err.response ? err.response.data.errors : {};
          console.log(err);
        });
    },
    cancelImport: function () {
      axios
        .post(
          `/import/contact/${this.importFileData.id}/cancel`,
          {},
          {
            headers: {
              "Content-Type": "multipart/form-data",
              Accept: "application/vnd.api+json",
            },
            onUploadProgress: function (progressEvent) {
              this.loading_progress = parseInt(
                Math.round((progressEvent.loaded / progressEvent.total) * 100)
              );
            }.bind(this),
          }
        )
        .then((xhr) => {
          this.error = null;
          this.step = "queue";
        })
        .catch((err) => {
          this.errors = !!err.response ? err.response.data.errors : {};
          console.log(err);
        });
    },
  },
  mounted() {
    this.modalElem = this.$refs.modal;

    $(this.modalElem).on("hidden.bs.modal", () => {
      this.closeModal();
    });
  },
};
</script>
