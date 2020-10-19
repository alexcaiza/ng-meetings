import { Component, OnInit } from '@angular/core';
import { DataserviceService } from 'src/app/dataservice.service';
import { Meeting } from 'src/app/meeting';

@Component({
    selector: 'app-estudiantes-meeting-list',
    templateUrl: './estudiantes-meeting-list.component.html',
    styleUrls: ['./estudiantes-meeting-list.component.css']
})
export class EstudiantesMeetingListComponent implements OnInit {

    estudiante: any;
    meeting: Meeting;

    constructor(
        private dataService: DataserviceService,
    ) { }

    ngOnInit(): void {
        this.estudiante = JSON.parse(this.dataService.getEstudiante())
        console.log('estudiante:');
        console.log(this.estudiante);
        console.log(this.dataService.getToken());

        this.dataService.findEstudianteMeeting(this.estudiante)
            .subscribe(response => {
                console.log(response);
                if (response) {
                    this.meeting = response.meeting;
                }
            }, err => {
                console.log(err);
            });
    }

}
