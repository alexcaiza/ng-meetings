import { Component, OnInit } from '@angular/core';
import { DataserviceService } from 'src/app/services/dataservice.service';
import { Meeting } from 'src/app/models/meeting';

import { Router } from '@angular/router';

import { AlertService } from '../../_alert';

import { Horario } from '../../models/horario';
import { Profesor } from '../../models/profesor';

import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, Validators, AbstractControl } from '@angular/forms';
import { Estudiante } from 'src/app/models/estudiante';

import { SelectItem } from 'primeng/api';
import { MeetingEnginieStatus } from 'src/app/models/meetingenginiestatus';

@Component({
    selector: 'app-docentes-meeting-list',
    templateUrl: './docentes-meeting-list.component.html',
    styleUrls: ['./docentes-meeting-list.component.css']
})
export class DocentesMeetingListComponent implements OnInit {

    options = {
        autoClose: true,
        keepAfterRouteChange: false
    };

    horas: Horario[] = [];
    profesores: Profesor[] = [];
    estudiante: Estudiante;
    meeting: Meeting = new Meeting();
    meetings: Meeting[];

    cols: any[];

    data: any;

    displayModal: boolean;

    public formGroup: FormGroup;

    typeRelationItems: SelectItem[];

    constructor(
        private formBuilder: FormBuilder,
        private dataService: DataserviceService,
        private router: Router,
        private alertService: AlertService
    ) { }

    ngOnInit(): void {

        console.log('ngOnInit');

        this.buildForm();

        var data: any;

        var profesor = this.dataService.getProfesor();

        data = this.dataService.getMeetingsProfesor(profesor).subscribe(response => {
            console.log(response);
            if (response) {
                this.meetings = response.meetings;
                console.log(response);
                console.log(this.meetings);
            }
        }, err => {
            console.log(err);
        });

        this.dataService.findProfesores()
            .subscribe(response => {
                console.log(response);
                this.profesores = response;
            }, err => {
                console.log(err);
            });

        console.log(data);

        if (data) {
            this.meetings = <Meeting[]>data.meetings;

            console.log('this.meetings');
            console.log(this.meetings);
        }

        this.cols = [
            { field: 'estudiante.nombres', header: 'Estudiante' },
            { field: 'estudiante.cedula', header: 'Cedula' },
            { field: 'estudiante.email', header: 'Email' },
            { field: 'fechameeting', header: 'Fecha solicitud' },
            { field: 'hora.horainicio', header: 'Hora' },
            { field: 'estadoanterior.nombre', header: 'Estado' }
        ];
    }

    private buildForm() {
        const dateLength = 10;
        const today = new Date().toISOString().substring(0, dateLength);

        const minPassLength = 4;

        this.formGroup = this.formBuilder.group({
            fechameeting: [null, Validators.required],
            profesorid: [null, Validators.required],
            horaid: [null, Validators.required],
            ralationTypeForm: [null, Validators.required],
            meetingurlTypeForm: [null, Validators.required],
            observacionTypeForm: [null, Validators.required],
        });
    }

    onRowEditInit(meeting: Meeting) {
        console.log(meeting);
    }

    showModalDialog(meeting: Meeting) {
        console.log('showModalDialog()');

        this.meeting = meeting;
        console.log(meeting);

        this.displayModal = true;

        var objParams = {};
        objParams['estadoanteriorvalor'] = meeting.meetingstatusvalue;
        objParams['valortipousuario'] = 'PRO';
        
        console.log(objParams);

        this.loadCatalogosMeeting(objParams);
    }

    findFechasDocente() {

        console.log('Method findFechasDocente()');

        console.log(this.formGroup.value);

        if (this.formGroup.get("profesorid").value == null) {
            this.alertService.error('Seleccione un profesor', this.options);
            return;
        }

        if (this.formGroup.get("fechameeting").value == null) {
            this.alertService.error('Seleccione una fecha', this.options);
            return;
        }

        this.dataService.getHoras(this.formGroup.value)
            .subscribe(response => {
                console.log(response);
                if (response) {
                    this.horas = response.horas;
                }
            }, err => {
                console.log(err);
            });
    }

    loadCatalogosMeeting(params) {
        this.typeRelationItems = [{ label: 'Seleccione', value: null }];
        let data: any[] = [];
        let mes: MeetingEnginieStatus[];
        
        this.dataService.findCatalogosEngineStatusMeeting(params).subscribe((response) => {
            data = response.data;
            mes = response.estados;
            mes.forEach((element) => {
                this.typeRelationItems.push({
                    label: element.estadoaccion.nombre, value: element.estadoaccion
                });
            });
        });
        console.log(this.typeRelationItems);
    }

    saveMeeting() {

        console.log('Method saveMeeting()');

        //console.log(angForm1.value);
        console.log(this.formGroup.value);
        console.log(this.meeting);

        this.displayModal=false;
      }

}
