<template>
  <div class="container-fluid">
    <form @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">edit</i>
              </div>
              <h4 class="card-title">
                {{ $t('global.edit') }}
                <strong>{{ $t('cruds.agama.title_singular') }}</strong>
              </h4>
            </div>
            <div class="card-body">
              <back-button></back-button>
            </div>
            <div class="card-body">
              <bootstrap-alert />
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{ $t('cruds.agama.fields.name') }}</label>
                    <div
                      class="form-group bmd-form-group"
                      :class="{
                        'has-items': entry.name,
                        'is-focused': activeField == 'name'
                      }"
                    >
                      <label class="bmd-label-floating">{{
                        $t('cruds.agama.fields.name_helper')
                      }}</label>
                      <input
                        class="form-control"
                        type="text"
                        :value="entry.name"
                        @input="updateName"
                        @focus="focusField('name')"
                        @blur="clearFocus"
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label>{{ $t('cruds.agama.fields.keterangan') }}</label>
                    <div
                      class="form-group bmd-form-group"
                      :class="{
                        'has-items': entry.keterangan,
                        'is-focused': activeField == 'keterangan'
                      }"
                    >
                      <label class="bmd-label-floating">{{
                        $t('cruds.agama.fields.keterangan_helper')
                      }}</label>
                      <input
                        class="form-control"
                        type="text"
                        :value="entry.keterangan"
                        @input="updateKeterangan"
                        @focus="focusField('keterangan')"
                        @blur="clearFocus"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <vue-button-spinner
                class="btn-primary"
                :status="status"
                :isLoading="loading"
                :disabled="loading"
              >
                {{ $t('global.save') }}
              </vue-button-spinner>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('AgamasSingle', ['entry', 'loading'])
  },
  beforeDestroy() {
    this.resetState()
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchEditData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('AgamasSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setName',
      'setKeterangan'
    ]),
    updateName(e) {
      this.setName(e.target.value)
    },
    updateKeterangan(e) {
      this.setKeterangan(e.target.value)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'agamas.index' })
          this.$eventHub.$emit('update-success')
        })
        .catch(error => {
          this.status = 'failed'
          _.delay(() => {
            this.status = ''
          }, 3000)
        })
    },
    focusField(name) {
      this.activeField = name
    },
    clearFocus() {
      this.activeField = ''
    }
  }
}
</script>
