/** @type {import('tailwindcss').Config} */
export default {
	purge: ["./index.html", "./src/**/*.{vue,js}"],
	theme: {
		extend: {
			colors: {
				primary: "#F6B352",
				secondary: "#F68657",
				"neutral-light": "#383A3F",
				"neutral-dark": "#1F2124",
			},
		},
	},
	plugins: [],
};
