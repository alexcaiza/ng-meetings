import { Component, OnInit } from '@angular/core';
import { SiblingService } from 'src/app/services/sibling.service';

@Component({
  selector: 'app-estudiantes-nav',
  templateUrl: './estudiantes-nav.component.html',
  styleUrls: ['./estudiantes-nav.component.css']
})
export class EstudiantesNavComponent implements OnInit {

  constructor(private siblingService: SiblingService) { }

  ngOnInit(): void {
  }

  callFindEstudianteMeetings() {
    console.log('Method callFindEstudianteMeetings()');
    this.siblingService.callFindEstudianteMeetings.next(true);
  }

}
