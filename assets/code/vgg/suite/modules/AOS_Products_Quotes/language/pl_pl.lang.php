��< ? p h p  
 / * *  
   *   P r o d u c t s ,   Q u o t a t i o n s   &   I n v o i c e s   m o d u l e s .  
   *   E x t e n s i o n s   t o   S u g a r C R M  
   *   @ p a c k a g e   A d v a n c e d   O p e n S a l e s   f o r   S u g a r C R M  
   *   @ s u b p a c k a g e   P r o d u c t s  
   *   @ c o p y r i g h t   S a l e s A g i l i t y   L t d   h t t p : / / w w w . s a l e s a g i l i t y . c o m  
   *    
   *   T h i s   p r o g r a m   i s   f r e e   s o f t w a r e ;   y o u   c a n   r e d i s t r i b u t e   i t   a n d / o r   m o d i f y  
   *   i t   u n d e r   t h e   t e r m s   o f   t h e   G N U   A F F E R O   G E N E R A L   P U B L I C   L I C E N S E   a s   p u b l i s h e d   b y  
   *   t h e   F r e e   S o f t w a r e   F o u n d a t i o n ;   e i t h e r   v e r s i o n   3   o f   t h e   L i c e n s e ,   o r  
   *   ( a t   y o u r   o p t i o n )   a n y   l a t e r   v e r s i o n .  
   *  
   *   T h i s   p r o g r a m   i s   d i s t r i b u t e d   i n   t h e   h o p e   t h a t   i t   w i l l   b e   u s e f u l ,  
   *   b u t   W I T H O U T   A N Y   W A R R A N T Y ;   w i t h o u t   e v e n   t h e   i m p l i e d   w a r r a n t y   o f  
   *   M E R C H A N T A B I L I T Y   o r   F I T N E S S   F O R   A   P A R T I C U L A R   P U R P O S E .     S e e   t h e  
   *   G N U   G e n e r a l   P u b l i c   L i c e n s e   f o r   m o r e   d e t a i l s .  
   *  
   *   Y o u   s h o u l d   h a v e   r e c e i v e d   a   c o p y   o f   t h e   G N U   A F F E R O   G E N E R A L   P U B L I C   L I C E N S E  
   *   a l o n g   w i t h   t h i s   p r o g r a m ;   i f   n o t ,   s e e   h t t p : / / w w w . g n u . o r g / l i c e n s e s  
   *   o r   w r i t e   t o   t h e   F r e e   S o f t w a r e   F o u n d a t i o n , I n c . ,   5 1   F r a n k l i n   S t r e e t ,  
   *   F i f t h   F l o o r ,   B o s t o n ,   M A   0 2 1 1 0 - 1 3 0 1     U S A  
   *  
   *   @ a u t h o r   S a l e s a g i l i t y   L t d   < s u p p o r t @ s a l e s a g i l i t y . c o m >  
   * /  
  
 $ m o d _ s t r i n g s   =   a r r a y   (  
     ' L B L _ A S S I G N E D _ T O _ I D '   = >   ' I D   P r z y p i s a n i a ' ,  
     ' L B L _ A S S I G N E D _ T O _ N A M E '   = >   ' P r z y p i s a n e   d o ' ,  
     ' L B L _ I D '   = >   ' I D ' ,  
     ' L B L _ D A T E _ E N T E R E D '   = >   ' D a t a   U t w o r z e n i a ' ,  
     ' L B L _ D A T E _ M O D I F I E D '   = >   ' D a t a   M o d y f i k a c j i ' ,  
     ' L B L _ M O D I F I E D '   = >   ' Z m o d y f i k o w a n e   p r z e z ' ,  
     ' L B L _ M O D I F I E D _ I D '   = >   ' I D   m o d y f i k u j c e g o ' ,  
     ' L B L _ M O D I F I E D _ N A M E '   = >   ' N a z w i s k o   m o d y f i k u j c e g o ' ,  
     ' L B L _ C R E A T E D '   = >   ' U t w o r z o n e   p r z e z ' ,  
     ' L B L _ C R E A T E D _ I D '   = >   ' I D   t w o r z c e g o ' ,  
     ' L B L _ D E S C R I P T I O N '   = >   ' I n f o r m a c j e   d o d a t k o w e ' ,  
     ' L B L _ D E L E T E D '   = >   ' U s u n i t e ' ,  
     ' L B L _ N A M E '   = >   ' N a z w a ' ,  
     ' L B L _ C R E A T E D _ U S E R '   = >   ' U t w o r z o n e   p r z e z   U |y t k o w n i k a ' ,  
     ' L B L _ M O D I F I E D _ U S E R '   = >   ' Z m o d y f i k o w a n e   p r z e z   U |y t k o w n i k a ' ,  
     ' L B L _ L I S T _ F O R M _ T I T L E '   = >   ' L i s t a   w y c e n ' ,  
     ' L B L _ M O D U L E _ N A M E '   = >   ' W y c e n y ' ,  
     ' L B L _ M O D U L E _ T I T L E '   = >   ' W y c e n y :   S t r o n a   g B� w n a ' ,  
     ' L B L _ H O M E P A G E _ T I T L E '   = >   ' M o j e   W y c e n y ' ,  
     ' L N K _ N E W _ R E C O R D '   = >   ' U t w � r z   w y c e n ' ,  
     ' L N K _ L I S T '   = >   ' W y c e n y ' ,  
     ' L B L _ S E A R C H _ F O R M _ T I T L E '   = >   ' W y s z u k a j   W y c e n ' ,  
     ' L B L _ H I S T O R Y _ S U B P A N E L _ T I T L E '   = >   ' P o d g l d   H i s t o r i i ' ,  
     ' L B L _ A C T I V I T I E S _ S U B P A N E L _ T I T L E '   = >   ' C z y n n o [c i ' ,  
     ' L B L _ A O S _ P R O D U C T S _ S U B P A N E L _ T I T L E '   = >   ' W y c e n y ' ,  
     ' L B L _ N E W _ F O R M _ T I T L E '   = >   ' N o w a   W y c e n a ' ,  
     ' L B L _ P R O D U C T _ N A M E '   = >   ' N a z w a ' ,  
     ' L B L _ P R O D U C T _ Q T Y '   = >   ' I l o [' ,  
     ' L B L _ P R O D U C T _ C O S T _ P R I C E '   = >   ' C e n a   z a k u p u ' ,  
     ' L B L _ P R O D U C T _ L I S T _ P R I C E '   = >   ' C e n a   s p r z e d a |y ' ,  
     ' L B L _ P R O D U C T _ U N I T _ P R I C E '   = >   ' C e n a   j e d n o s t k o w a ' ,  
     ' L B L _ P R O D U C T _ D I S C O U N T '   = >   ' R a b a t ' ,  
     ' L B L _ P R O D U C T _ D I S C O U N T _ A M O U N T '   = >   ' K w o t a   r a b a t u ' ,  
     ' L B L _ D I S C O U N T '   = >   ' T y p   r a b a t u ' ,  
     ' L B L _ V A T _ A M T '   = >   ' K w o t a   V A T ' ,  
     ' L B L _ V A T '   = >   ' V A T ' ,  
     ' L B L _ P R O D U C T _ T O T A L _ P R I C E '   = >   ' K w o t a   n e t t o ' ,  
     ' L B L _ P R O D U C T _ N O T E '   = >   ' I n f o r m a c j e   d o d a t k o w e ' ,  
     ' Q u o t e '   = >   ' ' ,  
     ' L B L _ A O S _ P R O D U C T S _ Q U O T E S _ S U B P A N E L _ T I T L E '   = >   ' W y c e n y ' ,  
     ' L B L _ F L E X _ R E L A T E '   = >   ' P o w i z a n e   z   ' ,  
     ' L B L _ P R O D U C T '   = >   ' P r o d u k t ' ,  
      
     ' L B L _ S E R V I C E _ M O D U L E _ N A M E '   = >   ' U s Bu g a ' ,  
     ' L B L _ L I S T _ N U M '   = >   ' N u m e r ' ,  
         ' L B L _ P R O D U C T S _ S E R V I C E S '   = >   ' P r o d u k t   /   U s Bu g a ' ,  
 ) ;  
 ? >  
 