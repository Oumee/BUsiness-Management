<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'user',
           'ajouter_utilisateur',
           'modifier_utilisateur',
           'supprimer_utilisateur',
           'active',
           'nonactive',
           'client',
           'ajouter_client',
           'modifier_client',
           'supprimer_client',
           'fournisseur',
           'ajouter_fournisseur',
           'modifier_fournisseur',
           'supprimer_fournisseur',
           'entreprise',
           'ajouter_entreprise',
           'modifier_entreprise',
           'supprimer_entreprise',
           'categorie',
           'ajouter_categorie',
           'modifier_categorie',
           'supprimer_categorie',
           'produit',
           'ajouter_produit',
           'modifier_produit',
           'supprimer_produit',
           'importer_produit',
           'achat',
           'ajouter_achat',
           'modifier_achat',
           'supprimer_achat',
           'vente',
           'ajouter_vente',
           'modifier_vente',
           'supprimer_vente',
           'role',
           'afficher_role',
           'ajouter_role',
           'modifier_role',
           'supprimer_role',
           'devis',
           'ajouter_devis',
           'modifier_devis',
           'supprimer_devis',
           'facture',
           'exporter_facture',
           'recherche_facture',
           'modifier_facture',
           'telecharger_facture',
           'imprimer_facture',
           'afficher_facture',
           'supprimer_facture',
           'modifier_solde_facture',
           'archivage_facture',
           'archivage_facture_recycler',
           'archivage_facture_supprimer',
           'accueil',
           'afficher tableau de bord',
           'affichage de notification',
          
             
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}