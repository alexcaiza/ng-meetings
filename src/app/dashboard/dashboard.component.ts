import { Component, OnInit } from '@angular/core';

import { first } from 'rxjs/operators';
import { Router } from '@angular/router';

import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, Validators, AbstractControl } from '@angular/forms';
import { DataserviceService } from '../services/dataservice.service';
import { Horario } from '../models/horario';
import { Profesor } from '../models/profesor';

import { AlertService } from '../_alert';

@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

    options = {
        autoClose: true,
        keepAfterRouteChange: false
    };

    public formGroup: FormGroup;

    horas: Horario[] = [];
    profesores: Profesor[] = [];

    Hobbies: any[] = [
        { "profesorId": 1, "name": "Profesor1" },
        { "profesorId": 2, "name": "Profesor2" },
        { "profesorId": 3, "name": "Profesor3" },
        { "profesorId": 4, "name": "Profesor4" },
        { "profesorId": 5, "name": "Profesor5" }
    ];

    constructor(private formBuilder: FormBuilder,
        private dataService: DataserviceService,
        private router: Router,
        private alertService: AlertService
        ) {
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
            horaid: [null, Validators.required]
        });
    }

    findFechasDocente() {
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

    saveMeeting(angForm1: FormGroup) {

        if (this.formGroup.get("profesorid").value == null) {
            this.alertService.error('Seleccione un profesor', this.options);
            return;
        }

        if (this.formGroup.get("fechameeting").value == null) {
            this.alertService.error('Seleccione una fecha', this.options);
            return;
        }

        if (this.formGroup.get("horaid").value == null) {
            this.alertService.error('Seleccione una hora en la fecha de busqueda', this.options);
            return;
        }

        let estudiante = this.dataService.getEstudiante();
        console.log(estudiante);
        
        console.log(this.formGroup.value);
       
        
        this.alertService.success('Los datos se registraron correctamente', this.options);
    }
}
