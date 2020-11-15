import { Component, OnInit } from '@angular/core';
import { SiblingService } from 'src/app/services/sibling.service';

@Component({
  selector: 'app-docentes-nav',
  templateUrl: './docentes-nav.component.html',
  styleUrls: ['./docentes-nav.component.css']
})
export class DocentesNavComponent implements OnInit {

  constructor(private siblingService: SiblingService) { }

  ngOnInit(): void {
  }

  executeFindMeetingsProfesor() {

    console.log('Method executeFindMeetingsProfesor()');
    /*
    if(this.siblingService.findMeetingsProfesor) {
      this.siblingService.findMeetingsProfesor();
    }
    */

   this.siblingService.callToggle.next(true);
  }

}
