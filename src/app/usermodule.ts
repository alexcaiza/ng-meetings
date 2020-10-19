export class Usermodule {
        public Id: number;
        public name: string;
        public pwd:string;
        public email:string;
        public mobile:string;
     
        constructor(Id:number,name: string,pwd:string,email:string,mobile:string) {
          this.Id = Id;
          this.name = name;
          this.pwd = pwd;
          this.email = email;
          this.mobile=mobile;
        }
    }
