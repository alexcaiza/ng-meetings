import { Component, OnInit } from '@angular/core';
import { DataserviceService } from 'src/app/dataservice.service';
import { Meeting } from 'src/app/meeting';

@Component({
  selector: 'app-docentes-meeting-list',
  templateUrl: './docentes-meeting-list.component.html',
  styleUrls: ['./docentes-meeting-list.component.css']
})
export class DocentesMeetingListComponent implements OnInit {

  meetings: Meeting[];

  data: any;

  constructor(private dataserviceService: DataserviceService) { }

  ngOnInit(): void {

    console.log('ngOnInit');

    var data: any;

    var profesor = this.dataserviceService.getProfesor();

    data = this.dataserviceService.getMeetingsProfesor(profesor).subscribe(response => {
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

}
