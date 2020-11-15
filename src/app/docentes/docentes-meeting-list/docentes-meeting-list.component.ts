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
import { AppMessages } from 'src/app/utils/app-messages';
import { Catalogo } from 'src/app/models/catalogo';
import { MeetingsConstants } from 'src/app/common/meetings-constants';
import { MeetingsService } from 'src/app/services/meetings.service';
import { SiblingService } from 'src/app/services/sibling.service';

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
    estudiante: Estudiante;
    meeting: Meeting = new Meeting();
    meetings: Meeting[];

    meetingstatus: Meeting[];

    cols: any[];

    data: any;

    public displayModal: boolean;
    public displayModalMeetingStatus: boolean;

    public formGroup: FormGroup;

    catalogosReunionDocente: SelectItem[];

    constructor(
        private formBuilder: FormBuilder,
        private dataService: DataserviceService,
        private router: Router,
        private alertService: AlertService,
        private meetingService: MeetingsService,
        private siblingService: SiblingService,
    ) { 
        //this.siblingService.findMeetingsProfesor = this.findMeetingsProfesor;

        this.siblingService.callToggle.subscribe(( data ) => {
            this.findMeetingsProfesor();
        });

    }

    /**
     * Metodo ngOnInit()
     */
    ngOnInit(): void {

        console.log('ngOnInit');

        this.buildForm();

        this.findMeetingsProfesor();

        this.cols = [
            { field: 'estudiante.nombres', header: 'Estudiante' },
            { field: 'estudiante.cedula', header: 'Cedula' },
            { field: 'estudiante.email', header: 'Email' },
            { field: 'fechameeting', header: 'Fecha solicitud' },
            { field: 'hora.horainicio', header: 'Hora' },
            { field: 'estadoactual.nombre', header: 'Estado' }
        ];
    }

    /**
     * Busca las reuniones del profesor
     */
    private findMeetingsProfesor() {

        console.log('Method findMeetingsProfesor()');

        var profesor = this.dataService.getProfesor();

        var data : any = this.dataService.getMeetingsProfesor(profesor).subscribe(response => {
            console.log(response);
            if (response) {
                this.meetings = response.meetings;
                console.log(response);
                console.log(this.meetings);
            }
        }, err => {
            console.log(err);
        });

        console.log(data);

        if (data) {
            this.meetings = <Meeting[]>data.meetings;
            console.log('this.meetings');
            console.log(this.meetings);
        }
    }

    /**
     * Metodo buildForm()
     */
    private buildForm() {
        this.formGroup = this.formBuilder.group({
            meetingEnginieStatusForm: [null, Validators.required],
            meetingurlTypeForm: [null, Validators.required],
            observacionTypeForm: [null, Validators.required],
        });
    }

    /**
     * Metodo saveMeetingDocente()
     */
    saveMeetingDocente() {
        console.log('Method saveMeetingDocente()');

        let meetingEnginieStatus : MeetingEnginieStatus = <MeetingEnginieStatus>this.formGroup.get('meetingEnginieStatusForm').value;

        if (meetingEnginieStatus == null 
            || meetingEnginieStatus == undefined
        ) {
            this.alertService.error('Seleccione el tipo de acción para gestionar la reunión', { id: 'alert-popup-meeting-docente' });
            return;
        }

        this.meeting.meetingAction = meetingEnginieStatus.estadoaccion;

        if (this.meeting.meetingAction.catalogovalor == MeetingsConstants.MEETING_ACTION_AGENDAR_PROFESOR) {
            if (this.meeting.meetingurl == null 
                || this.meeting.meetingurl == undefined
                || this.meeting.meetingurl == ''
            ) {
                this.alertService.error('Ingrese el id del zoom para la reunión', { id: 'alert-popup-meeting-docente' });
                return;
            }
        } else {
            if (this.meeting.meetingurl == undefined) {
                this.meeting.meetingurl = null;
            }
        }

        if (this.meeting.observacion == null 
            || this.meeting.observacion == undefined
            || this.meeting.observacion == ''
        ) {
            this.alertService.error('Ingrese una observacion', { id: 'alert-popup-meeting-docente' });
            return;
        }

        let profesor = this.dataService.getProfesor();
        let objProfesor : Profesor = <Profesor> JSON.parse(profesor);
        
        let objMeeting : any = {};

        objMeeting.usuarioid = objProfesor.usuarioid;
        objMeeting.profesorid = objProfesor.profesorid;
        objMeeting.meetingid = this.meeting.meetingid;
        objMeeting.meeting = this.meeting;
        objMeeting.meeting.meetingEnginieStatus = meetingEnginieStatus;
        
        console.log('objMeeting:');
        console.log(objMeeting);
        
        this.meetingService.workflowMeeting(objMeeting).subscribe(response => {
                console.log('response workflowMeeting()');
                console.log(response);
                if (response != undefined) {
                    if (response.error === 0) {
                        // Cierra el modal
                        this.displayModal=false;
                        // Consulta las reuniones del profesor para actualizar en la pantalla
                        this.findMeetingsProfesor();
                        // Mensaje de confirmacion
                        this.alertService.success('Los datos de la reunion se registraron correctamente', AppMessages.optionsMessages);
                    } else {
                        this.alertService.error(response.message, AppMessages.optionsMessages);
                    }
                } else {
                    this.alertService.error("A ocurrido un problema al registar los datos de la reunion", AppMessages.optionsMessages);
                }
            }, (err) => {
            console.log(err);
            }
        );
        
      }

    /**
     * Metodo onRowEditInit()
     * @param meeting 
     */
    onRowEditInit(meeting: Meeting) {
        console.log(meeting);
    }

    /**
     * Metodo openModalMeetingDocente()
     * @param meeting 
     */
    openModalMeetingDocente(meeting: Meeting) {
        console.log('openModalMeetingDocente()');

        this.alertService.clear('alert-popup-meeting-docente');

        this.meeting = meeting;
        console.log(meeting);
        
        this.displayModal = true;

        var objParams = {};
        objParams['meetingid'] = meeting.meetingid;
        objParams['estadoanteriorvalor'] = meeting.meetingstatusvalue;
        objParams['valortipousuario'] = 'PRO';
        
        console.log('meeting');
        console.log(objParams);

        //Consulta los estados para la reunion
        this.findCatalogosMeeting(objParams);
    }

    openModalModalMeetingStatus(meeting: Meeting) {
        console.log('openModalModalMeetingStatus()');

        this.meeting = meeting;
        console.log(meeting);
        
        this.displayModalMeetingStatus = true;

        var objParams = {};
        objParams['meetingid'] = meeting.meetingid;
        objParams['estadoanteriorvalor'] = meeting.meetingstatusvalue;
        objParams['valortipousuario'] = 'PRO';
        
        console.log('meeting');
        console.log(objParams);

        this.findMeetingStatus(meeting);

    }
    
    /**
     * Busca las estado de la reunion
     */
    private findMeetingStatus(meeting) {
        var profesor = this.dataService.getProfesor();

        var data : any = this.meetingService.findMeetingStatusById(meeting).subscribe(response => {
            console.log(response);
            if (response) {
                this.meetingstatus = response.meetingstatus;
                console.log(response);
                console.log(this.meetingstatus);
            }
        }, err => {
            console.log(err);
        });

        console.log('data.meetingstatus');
        console.log(data);

        if (data) {
            this.meetingstatus = <Meeting[]>data.meetingstatus;
            console.log('this.meetingstatus');
            console.log(this.meetingstatus);
        }
    }

    /**
     * Consulta los estados para la reunion dado como parametro el estado actual de reunion
     * 
     * @param params 
     */
    findCatalogosMeeting(params) {
        this.catalogosReunionDocente = [{ label: 'Seleccione', value: null }];
        let data: any[] = [];
        let meetingEnginieStatus: MeetingEnginieStatus[];
        
        this.dataService.findCatalogosEngineStatusMeeting(params).subscribe((response) => {
            data = response.data;
            meetingEnginieStatus = response.estados;
            meetingEnginieStatus.forEach((element) => {
                this.catalogosReunionDocente.push({
                    label: element.estadoaccion.nombre, value: element
                });
            });
        });
        console.log(this.catalogosReunionDocente);
    }
}
