import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EstudiantesMeetingListComponent } from './estudiantes-meeting-list.component';

describe('EstudiantesMeetingListComponent', () => {
  let component: EstudiantesMeetingListComponent;
  let fixture: ComponentFixture<EstudiantesMeetingListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EstudiantesMeetingListComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(EstudiantesMeetingListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
