import { Component, OnInit } from '@angular/core';

import { first } from 'rxjs/operators';
import { Router } from '@angular/router';

import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, Validators, AbstractControl } from '@angular/forms';

import { DataserviceService } from '../../services/dataservice.service';

import { Horario } from '../../models/horario';
import { Profesor } from '../../models/profesor';

import { AlertService } from '../../_alert';
import { Estudiante } from 'src/app/models/estudiante';
import { MeetingsService } from 'src/app/services/meetings.service';
import { AppMessages } from 'src/app/utils/app-messages';

@Component({
    selector: 'app-estudiantes-meeting-register',
    templateUrl: './estudiantes-meeting-register.component.html',
    styleUrls: ['./estudiantes-meeting-register.component.css']
})
export class EstudiantesMeetingRegisterComponent implements OnInit {

   

    public formGroup: FormGroup;

    horas: Horario[] = [];
    profesores: Profesor[] = [];

    public value;

    Hobbies: any[] = [
        { "profesorId": 1, "name": "Profesor1" },
        { "profesorId": 2, "name": "Profesor2" },
        { "profesorId": 3, "name": "Profesor3" },
        { "profesorId": 4, "name": "Profesor4" },
        { "profesorId": 5, "name": "Profesor5" }
    ];

    date3: Date;

    constructor(private formBuilder: FormBuilder,
        private dataService: DataserviceService,
        private meetingService: MeetingsService,
        private router: Router,
        private alertService: AlertService
    ) {
        this.value = new Date();
    }

    ngOnInit(): void {

        this.buildForm();

        this.dataService.findProfesores()
            .subscribe(response => {
                console.log(response);
                this.profesores = response;
            }, err => {
                console.log(err);
            });
    }

    private buildForm() {
        const dateLength = 10;
        const today = new Date().toISOString().substring(0, dateLength);

        const minPassLength = 4;

        this.formGroup = this.formBuilder.group({
            fechameeting: [null, Validators.required],
            profesorid: [null, Validators.required],
            horaid: [null, Validators.required],
            value: [null, Validators.required]
        });
    }

    findFechasDocente() {

        console.log('Method findFechasDocente()');

        console.log(this.formGroup.value);

        if (this.formGroup.get("profesorid").value == null) {
            this.alertService.error('Seleccione un profesor', AppMessages.optionsMessages);
            return;
        }

        if (this.formGroup.get("fechameeting").value == null) {
            this.alertService.error('Seleccione una fecha', AppMessages.optionsMessages);
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

    /*
        Guarda los datos de un meeting en la bbdd
     */
    saveMeeting(angForm1: FormGroup) {

        console.log('Method saveMeeting()');

        if (this.formGroup.get("profesorid").value == null) {
            this.alertService.error('Seleccione un profesor', AppMessages.optionsMessages);
            return;
        }

        if (this.formGroup.get("fechameeting").value == null) {
            this.alertService.error('Seleccione una fecha', AppMessages.optionsMessages);
            return;
        }

        if (this.formGroup.get("horaid").value == null) {
            this.alertService.error('Seleccione una hora en la fecha de busqueda', AppMessages.optionsMessages);
            return;
        }

        let estudiante = this.dataService.getEstudiante();
        console.log(estudiante);

        let objEstudiante = JSON.parse(estudiante);
        console.log(objEstudiante);

        console.log(this.formGroup.value);

        let values = this.formGroup.value;
        values.estudianteid = objEstudiante?.estudianteid;
        values.usuarioid = objEstudiante?.usuarioid;

        this.meetingService.saveMeetingEstudiante(values).subscribe(response => {
                console.log('response saveMeetingEstudiante()');
                console.log(response);
                if (response != undefined) {
                    if (response.error === 0) {
                        const redirect = this.dataService.redirectUrl ? this.dataService.redirectUrl : '/estudiantes/estudiantes-meeting-list';
                        this.router.navigate([redirect]);

                        this.alertService.success('Los datos se registraron correctamente', AppMessages.optionsMessages);
                    } else {
                        this.alertService.error(response.message, AppMessages.optionsMessages);
                    }
                } else {
                    this.alertService.error("A ocurrido un problema al registar los datos de la cita", AppMessages.optionsMessages);
                }
            }, (err) => {
            console.log(err);
            }
        );
    }
}
