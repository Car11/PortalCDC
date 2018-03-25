class Comment {
    // Constructor
    constructor(id, taskId, userId, username, name, comment, reference, dateCreation, dateModification) {
        this.id = id || null;
        this.taskId = taskId || null;
        this.userId= userId || null;
        this.username= username || '';
        this.name= name || '';
        this.comment= comment || '';
        this.reference= reference || '';
        this.dateCreation= dateCreation || null;
        this.dateModification= dateModification || null;
    }

    //Get
    get Load() {
        return this;
    }
}