/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const formatDay = 'YYYY-MM-DD';
let init;
const app = new Vue({
    el: '#app',
    delimiters: ['{!', '!}'],
    data: {
        cache: true,
        today: moment(),
        day: moment(),
        dayCalendar: null,
        services: [],
        formErrors: {},
        entities: false,
        model: {
            number: 1,
            service: {
                id: null,
                agency_id: null,
                turn: null,
                date: null,
                route_id: null,
                vehicle_id: null,
                chauffeur_id: null,
                courier: null,
                passengers: null,
                hour: null,
            },
            entity_type: '',
            setting: {
                id: null,
                name: '',
                chauffeur_id: null,
                number_passengers: null,
            }
        },
        agencies: [],
        vehicles: [],
        chauffeurs: [],
        routes: [],
        types_trips: []
    },
    watch: {
        cache: (value) => {
            app.saveInStorage("cacheIsEnabled", value);
        },
        formErrors: (errors) => {
            if (JSON.stringify(errors) === '{}') {
                $('.has-error').removeClass('has-error');
            }

            Object.keys(errors).forEach(function (key) {
                $('#container_' + key).addClass('has-error');
            });
        }
    },
    methods: {
        cacheIsEnabled: () => {
            return app.getFromStorage("cacheIsEnabled");
        },
        saveInStorage: (key, value) => {
            localStorage.setItem(key, JSON.stringify(value));
            return this;
        },
        inStorage: (key) => {
            return localStorage.hasOwnProperty(key);
        },
        getFromStorage: (key) => {
            return JSON.parse(localStorage.getItem(key));
        },
        init: () => {
            clearTimeout(init);
            init = setTimeout(app._init(), 1000);
        },
        _init: () => {
            let cache = app.getFromStorage('cacheIsEnabled') || false;
            app.cache = cache;
            app.loadEntities();
            app.services = [];
            app.dayCalendar = app.day.calendar().toString();
            let qday = app.day.clone();
            let uri = app.getUri(qday);

            if (cache && app.inStorage(uri)) {
                if (!qday.isSame(app.day)) {
                    return;
                }
                app.services = app.getFromStorage(uri);
                app.clearService();
                return;
            }
            axios.get(uri).then((resp) => {
                if (!qday.isSame(app.day)) {
                    return;
                }
                app.services = resp.data;
                app.saveInStorage(uri, app.services);
                app.clearService();
            });
        },
        getUri: (day) => {
            return '/bookings?day=' + day.format('YYYY-MM-DD');
        },
        addToServices: (service) => {
            app.services.push(service);
            app.saveInStorage(app.getUri(app.day), app.services);
        },
        updateService: (index, service) => {
            app.services[index] = service;
            app.saveInStorage(app.getUri(app.day), app.services);
        },
        loadEntities: () => {

            let requests = [];
            let entities = ['agencies', 'vehicles', 'chauffeurs', 'routes', 'types_trips'];
            entities.forEach((e) => {

                if (app.cache && app.inStorage(e)) {
                    app[e] = app.getFromStorage(e) || [];
                    return;
                }

                requests.push(
                    axios.get('/' + e)
                );
            });

            if (0 === requests.length) {
                return;
            }

            axios.all(requests)
                .then((data) => {
                    entities.forEach((e, i) => {
                        app[e] = data[i].data;
                        app.saveInStorage(e, data[i].data);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        formSetting: (entity, object) => {
            app.model.entity_type = entity;
            app.clearSetting();
            let data = object || app.model.setting;
            app.model.setting = JSON.parse(JSON.stringify(data));
            $('#formSetting').modal('show');

        },
        doneFormSetting: () => {
            if (app.model.setting.id === null) {
                return app.settingCreate(app.model.entity_type);
            }

            return app.settingUpdate(app.model.entity_type);
        },
        settingCreate: (entity) => {
            axios.post(entity, app.model.setting)
                .then((res) => {
                    app.addSetting(entity, res.data);
                    $('#formSetting').modal('hide');
                    app.clearSetting();
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
                });
        },
        settingUpdate: (entity) => {
            axios.put(entity + '/' + app.model.setting.id, app.model.setting)
                .then((res) => {
                    let object = res.data;
                    let index = app[entity].findIndex((e) => {
                        return e.id == app.model.setting.id;
                    });
                    app.updateSetting(entity, index, object);
                    $('#formSetting').modal('hide');
                    app.clearSetting();
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
                });
        },
        addSetting: (entity, value) => {
            app[entity].push(value);
            app.saveInStorage(entity, app[entity]);
        },
        updateSetting: (entity, index, object) => {
            app[entity][index] = object;
            app.saveInStorage(entity, app[entity]);
        },
        clearService: () => {
            app.model.service = {
                id: null,
                agency_id: null,
                turn: null,
                date: app.day.clone().format('YYYY-MM-DD'),
                route_id: null,
                vehicle_id: null,
                chauffeur_id: null,
                courier: null,
                passengers: null,
                hour: '00:00',
            }
        },
        clearSetting: () => {
            app.model.setting = {
                id: null,
                name: '',
                chauffeur_id: null,
                number_passengers: null,
            }
        },
        goToday: () => {
            app.day = moment();
            app.init();
        },
        nextDay: () => {
            app.day = app.day.clone().add(1, 'day');
            app.init();
        },
        lastDay: () => {
            app.day = app.day.clone().add(-1, 'day');
            app.init();
        },
        doneForm: () => {
            app.formErrors = {};
            if (app.model.service.id === null) {
                return app.createServices();
            }
            axios.put('/bookings/' + app.model.service.id, app.model.service)
                .then(function (res) {
                    let service = res.data;
                    let index = app.services.findIndex((e) => {
                        return e.id == service.id;
                    });
                    app.updateService(index, service);
                    app.clearService();
                    $('#formService').modal('hide');
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
                });
        },
        createServices: () => {
            let requests = [];
            for (let i = 1; i <= app.model.number; i++) {
                requests.push(axios.post('/bookings', app.model.service));
            }
            axios.all(requests)
                .then((data) => {
                    data.forEach((resp) => {
                        app.addToServices(resp.data);
                    });
                    $('#formService').modal('hide');
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
                });
        },
        createService: () => {
            app.clearService();
            $('#formService').modal('show');
        },
        edit: (service) => {
            app.model.service = JSON.parse(JSON.stringify(service));
            b
            $('#formService').modal('show');
        },
        routeName: (id) => {
            return app.findName(id, 'routes');
        },
        vehicleName: (id) => {
            return app.findName(id, 'vehicles');
        },
        agencyName: (id) => {
            return app.findName(id, 'agencies');
        },
        chauffeurName: (id) => {
            return app.findName(id, 'chauffeurs');
        },
        findName: (id, type) => {
            if (id === null) {
                return '';
            }
            if (app[type] === undefined) {
                return '';
            }
            return (app[type].find((c) => {
                return c.id === id;
            })).name;
        }
    }
});
