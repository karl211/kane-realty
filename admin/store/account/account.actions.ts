import { Commit } from 'vuex'
import { Auth } from  '~/services/auth'

declare global {
    interface Window {
        impersonate_token: any;
        location: Location;
    }
}

export default {

  login({ commit }: { commit: Commit }, payload:any) {
    Auth.login(payload).then((res: any)=>{
      commit('setUser', res.data.data);
    });
    },

  backToAdmin({ commit }: { commit: Commit }, payload:any){
    Auth.logout().then(response=>{
      if(response.status === 200){
        window.impersonate_token = null;

        localStorage.removeItem('ethesia');
      }
    }).then(res=>{
        window.location.href = (process.env.ADMIN_URL) ? process.env.ADMIN_URL : '';
    });
  },

    impersonate({ commit }: { commit: Commit }, payload:any){
       return  new Promise((resolve, reject)=>{
         Auth.impersonate(payload).then(response=>{
           commit('setUser', response.data.data)
           commit('SET_IMPERSONATE', true)
           resolve(response.data.data);
        }).catch(e=>{
          reject(e);
        });
      });
    },

    fetchAuthUser({ commit }: { commit: Commit }) {
        return new Promise(function(resolve, reject){
            Auth.authUser().then((response : any) => {
                commit('setAuthUser', response.data)
            }).catch(function(error){
                // this.$router.push('')
                reject(error);
            });
        });


    },

    register({ commit }: { commit: Commit }, payload: object){
      Auth.signUp(payload).then((response: any)=>{
        console.log(response);
      })
    },

    getAllNotifications({ commit }: { commit: Commit }, payload: object){
      Auth.getAllNotifications(payload).then((res: any)=> res.data).then((response: any)=>{
        commit('SET_NOTIFICATIONS', response.data)
      })
    },

    markReadNotifications({ commit }: { commit: Commit }, payload: object){
      Auth.markReadNotifications(payload).then((res: any)=> res.data).then((response: any)=>{
        commit('SET_MARK_READ', response.data)
      })
    },
    markAllNotifications({ commit }: { commit: Commit }, payload: object){
      Auth.markAllNotifications(payload).then((res: any)=> res.data).then((response: any)=>{
        commit('SET_MARK_READ_ALL', response.data)
      })
    },



    deactivate({ commit }: { commit: Commit }){
     return new Promise((resolve: any, reject:any)=>{
        Auth.deactivate().then((response: any)=>{
          resolve(response)
      }).catch((error: any)=>{
        reject(error)
      })
     });
    },

    removeState({ commit }: { commit: Commit }, payload: any){
     return new Promise((resolve: any, reject:any)=>{
        Auth.removeState(payload).then((response: any)=>{
          resolve(response)
      }).catch((error: any)=>{
        reject(error)
      })
     });
    }


}
