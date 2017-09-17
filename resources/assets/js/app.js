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
        formServiceMessage: '',
        formLiquidationMessage: '',
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
                type_trip_id: null,
                chauffeur_id: null,
                courier: null,
                passengers: null,
                hour: null,
                paying: null,
                enabled: true,
            },
            entity_type: '',
            setting: {
                id: null,
                name: '',
                chauffeur_id: null,
            },
            rule: {
                id: null,
                agency_id: 'ANY',
                turn: 'ANY',
                route_id: 'ANY',
                type_trip_id: 'ANY',
                number_passengers: 0,
                priority: 0,
                price: null,
            },
            liquidation: {
                agency_id: null,
                date_init: null,
                date_end: null,
            }
        },
        rules: [],
        agencies: [],
        vehicles: [],
        chauffeurs: [],
        routes: [],
        types_trips: [],
        incompletes: [],
        liquidations: [],
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
        clearService: () => {
            app.model.service = {
                id: null,
                agency_id: null,
                turn: null,
                date: app.day.clone().format('YYYY-MM-DD'),
                route_id: null,
                vehicle_id: null,
                type_trip_id: null,
                chauffeur_id: null,
                courier: null,
                passengers: null,
                hour: '00:00',
                paying: null,
                enabled: true,
            }
        },
        clearLiquidation: () => {
            app.model.liquidation = {
                agency_id: null,
                date_init: null,
                date_end: null,
            }
        },
        clearSetting: () => {
            app.model.setting = {
                id: null,
                name: '',
                chauffeur_id: null,
            }
        },
        clearRule: () => {
            app.model.rule = {
                id: null,
                agency_id: 'ANY',
                turn: 'ANY',
                route_id: 'ANY',
                type_trip_id: 'ANY',
                number_passengers: 0,
                priority: 0,
                price: null
            }
        },
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
            axios.get(uri).then((res) => {
                if (!qday.isSame(app.day)) {
                    return;
                }
                app.services = res.data;
                app.saveInStorage(uri, app.services);
                app.clearService();
            });
        },
        loadLiquidations: () => {

            let requests = [];
            let entities = ['liquidations'];
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
        getIncompletes: () => {
            axios.get('/bookings?filter[enabled]=1&filterOr[type_trip_id]=null&filterOr[passengers]=null')
                .then((res) => {
                    app.incompletes = res.data;
                });
        },
        getUri: (day) => {
            return '/bookings?filter[date]=' + day.format('YYYY-MM-DD');
        },
        addToServices: (service) => {
            app.services.push(service);
            app.saveInStorage(app.getUri(app.day), app.services);
            app.getIncompletes();
        },
        updateService: (index, service) => {
            app.services[index] = service;
            app.saveInStorage(app.getUri(app.day), app.services);
            app.getIncompletes();

        },
        loadEntities: () => {

            let requests = [];
            let entities = ['agencies', 'vehicles', 'chauffeurs', 'routes', 'types_trips', 'rules'];
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
        formLiquidation: () => {
            app.formLiquidationMessage = '';
            app.clearLiquidation();
            $('#formLiquidation').modal('show');

        },
        doneFormLiquidation: () => {
            app.formLiquidationMessage = '';
            axios.post('liquidations', app.model.liquidation)
                .then((res) => {
                    app.addSetting('liquidations', res.data);
                    $('#formLiquidation').modal('hide');
                    app.clearRule();
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
                    app.formLiquidationMessage = errors.response.data.agency_id[0]
                });
        },
        deleteLiquidation: (liquidation) => {

            let disableConfirm = confirm("Este registro es inreproducible, y lo va a borrar \n\r esta seguro?");
            if (false == disableConfirm) {
                return;
            }

            axios.delete('liquidations/' + liquidation.id).then(() => {
                let index = app.liquidations.findIndex((e) => {
                    return e.id == liquidation.id;
                });
                app._removeSetting('liquidations', index);
            });
        },
        removeSetting: (setting, entity) => {

            let disableConfirm = confirm("Este registro es inreproducible, y lo va a borrar \n\r esta seguro que desea borrar a: " + entity.name + "?");
            if (false == disableConfirm) {
                return;
            }

            axios.delete(setting + '/' + entity.id).then(() => {
                let index = app[setting].findIndex((e) => {
                    return e.id == entity.id;
                });
                app._removeSetting(setting, index);
            });
        },
        formRule: (object) => {
            app.clearRule();
            let data = object || app.model.rule;
            app.model.rule = JSON.parse(JSON.stringify(data));
            $('#formRule').modal('show');

        },
        doneFormRule: () => {
            if (app.model.rule.id === null) {
                return app.ruleCreate();
            }

            return app.ruleUpdate();
        },
        ruleCreate: () => {
            axios.post('rules', app.model.rule)
                .then((res) => {
                    app.addSetting('rules', res.data);
                    $('#formRule').modal('hide');
                    app.clearRule();
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
                });
        },
        ruleUpdate: () => {
            axios.put('rules/' + app.model.rule.id, app.model.rule)
                .then((res) => {
                    let object = res.data;
                    let index = app['rules'].findIndex((e) => {
                        return e.id == app.model.rule.id;
                    });
                    app.updateSetting('rules', index, object);
                    $('#formRule').modal('hide');
                    app.clearRule();
                })
                .catch((errors) => {
                    app.formErrors = errors.response.data;
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
        _removeSetting: (entity, index) => {
            app[entity].splice(index, 1);
            app.saveInStorage(entity, app[entity]);
        },
        goToday: () => {
            app.day = moment();
            app.init();
        },
        goTo: (momentDate) => {
            app.day = momentDate;
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
            app.formServiceMessage = app.today.isAfter(app.day) ? 'Este servicio ya paso (!?)' : '';
            app.clearService();
            $('#formService').modal('show');
        },
        edit: (service) => {
            app.formServiceMessage = moment(app.today.format('YYYY-MM-DD')).isAfter(moment(app.model.service.date).format('YYYY-MM-DD')) ? 'Estas editando una fecha pasada.' : '';
            app.model.service = JSON.parse(JSON.stringify(service));
            $('#formService').modal('show');
        },
        disable: (id) => {
            let disableConfirm = confirm("Este registro no podra ser liquidado a la agencia \n\r esta seguro?");
            if (false == disableConfirm) {
                return;
            }
            let service = app.services.find((s) => {
                return s.id === id;
            });
            service.enabled = false;
            axios.put('/bookings/' + service.id, service)
                .then(function (res) {
                    let service = res.data;
                    let index = app.services.findIndex((e) => {
                        return e.id == service.id;
                    });
                    app.updateService(index, service);
                })
                .catch((errors) => {
                    alert('Intente mas tarde \r\n' + errors.message);
                });


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
        typeTripName: (id) => {
            return app.findName(id, 'types_trips');
        },
        findName: (id, type) => {
            if (id === null) {
                return '';
            }
            if (app[type] === undefined) {
                return '';
            }
            let entity = (app[type].find((c) => {
                return c.id == id;
            }));

            return (entity !== undefined) ? entity.name : id;
        },
        _moment: data => moment(data)
    }
});
