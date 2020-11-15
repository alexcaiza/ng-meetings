import { Component, OnInit } from '@angular/core';
import { DataserviceService } from 'src/app/services/dataservice.service';
import { Meeting } from 'src/app/models/meeting';
import { AlertService } from 'src/app/_alert';
import { AppMessages } from 'src/app/utils/app-messages';

import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, Validators, AbstractControl } from '@angular/forms';
import { MeetingsService } from 'src/app/services/meetings.service';
import { MeetingsConstants } from 'src/app/common/meetings-constants';
import { SiblingService } from 'src/app/services/sibling.service';

@Component({
    selector: 'app-estudiantes-meeting-list',
    templateUrl: './estudiantes-meeting-list.component.html',
    styleUrls: ['./estudiantes-meeting-list.component.css']
})
export class EstudiantesMeetingListComponent implements OnInit {

    estudiante: any;
    meeting: Meeting;

    public formGroup: FormGroup;

    constructor(
        private dataService: DataserviceService,
        private meetingService: MeetingsService,
        private alertService: AlertService,
        private formBuilder: FormBuilder,
        private siblingService: SiblingService,
    ) { 
        this.siblingService.callFindEstudianteMeetings.subscribe((data) => {
            this.findEstudianteMeetings();
        });
    }

    ngOnInit(): void {

        this.estudiante = JSON.parse(this.dataService.getEstudiante())

        this.buildForm();

        this.findEstudianteMeetings();
    }

    private findEstudianteMeetings() {
        console.log('Metodo findEstudianteMeetings()');
        this.dataService.findEstudianteMeeting(this.estudiante).subscribe(response => {
            console.log(response);
            if (response) {
                this.meeting = null;
                if (response.count > 0) {
                    this.meeting = response.meetings[0];
                    /*
                    if (this.meeting && this.meeting.observacion) {
                        this.formGroup.patchValue({
                            observacion: this.meeting.observacion                
                          });                          
                    }
                    */
                } else {
                    this.alertService.info(response.message, AppMessages.optionsMessages);
                }
            }
        }, err => {
            console.log(err);
        });
    }

    private buildForm() {
        //let observacion = this.meeting.observacion;       
        this.formGroup = this.formBuilder.group({
            observacion: [null, Validators.required]
        });
    }

    public cancelarMeetingEstudiante2() {
        console.log('Metodo cancelarMeetingEstudiante2()');
        console.log(this.formGroup.value);
        console.log(this.meeting);
    }

    /*
        Guarda los datos de un meeting en la bbdd
     */
    public cancelarMeetingEstudiante() {

        console.log('Metodo cancelarMeetingEstudiante()');

        if (this.formGroup.get("observacion").value == null) {
            this.alertService.error('Ingrese una observacion', AppMessages.optionsMessages);
            return;
        }

        let estudiante = this.dataService.getEstudiante();
        let objEstudiante = JSON.parse(estudiante);
        
        let values = this.formGroup.value;
        values.meetingid = this.meeting.meetingid;
        values.meetingsstatusid = this.meeting.meetingsstatusid;
        values.meetingstatuscode = this.meeting.meetingstatuscode;;
        values.meetingstatusvalue = this.meeting.meetingstatusvalue;;
        values.estudianteid = objEstudiante?.estudianteid;
        values.usuarioid = objEstudiante?.usuarioid;
        values.observacion = this.formGroup.get("observacion").value;

        values.action = MeetingsConstants.MEETING_ACTION_CANCELAR_ESTUDIANTE;

        console.log(values);

        this.meetingService.cancelMeetingEstudiante(values).subscribe(response => {
                console.log('response cancelMeetingEstudiante()');
                console.log(response);
                if (response != undefined) {
                    if (response.error === 0) {
                        this.alertService.success('Los reunion se cancelo correctamente', AppMessages.optionsMessages);
                        this.findEstudianteMeetings();
                    } else {
                        this.alertService.error(response.message, AppMessages.optionsMessages);
                    }
                } else {
                    this.alertService.error("A ocurrido un problema al cancelar la reunion, por favor cominiquese con el administrador", AppMessages.optionsMessages);
                }
            }, (err) => {
            console.log(err);
            }
        );
    }

}
